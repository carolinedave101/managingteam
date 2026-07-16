import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Alpine = Alpine;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        items: [],
        init() {
            const stored = localStorage.getItem('cart');
            if (stored) {
                try { this.items = JSON.parse(stored); } catch { this.items = []; }
            }
            window.addEventListener('cart-loaded-from-server', (e) => {
                if (e.detail?.items && this.items.length === 0) {
                    this.items = e.detail.items;
                    this.save();
                }
            });
        },
        save() {
            localStorage.setItem('cart', JSON.stringify(this.items));
        },
        addItem(id, name, price, quantity = 1, type = 'membership', metadata = {}) {
            const existing = this.items.find(i => i.id === id);
            if (existing) {
                existing.quantity += quantity;
            } else {
                this.items.push({ id, name, price, quantity, type, metadata });
            }
            this.save();
        },
        removeItem(id) {
            this.items = this.items.filter(i => i.id !== id);
            this.save();
        },
        updateQuantity(id, quantity) {
            const item = this.items.find(i => i.id === id);
            if (item) {
                item.quantity = Math.max(1, quantity);
                this.save();
            }
        },
        clear() {
            this.items = [];
            this.save();
        },
        get total() {
            return this.items.reduce((sum, i) => sum + i.price * i.quantity, 0);
        },
        get totalItems() {
            return this.items.reduce((sum, i) => sum + i.quantity, 0);
        },
    });

    Alpine.store('notifications', {
        unreadMessages: 0,
        toasts: [],
        init() {
            const meta = document.querySelector('meta[name="unread-messages"]');
            if (meta) this.unreadMessages = parseInt(meta.content, 10);
            this.$watch('toasts', () => {
                if (this.toasts.length > 0) {
                    setTimeout(() => {
                        if (this.toasts.length > 0) this.toasts.shift();
                    }, 5000);
                }
            });
        },
        incrementMessages(count = 1) {
            this.unreadMessages += count;
        },
        addToast(message, type = 'info', duration = 5000) {
            const id = Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
            this.toasts.push({ id, message, type });
            if (duration > 0) {
                setTimeout(() => this.removeToast(id), duration);
            }
            return id;
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
    });

    Alpine.store('ui', {
        mobileMenuOpen: false,
        activeModal: null,
        loading: false,
        toggleMobileMenu() { this.mobileMenuOpen = !this.mobileMenuOpen; },
        openModal(name) { this.activeModal = name; },
        closeModal() { this.activeModal = null; },
    });

    Alpine.store('wallet', {
        balance: 0,
        init() {
            const el = document.getElementById('wallet-balance');
            if (el) {
                this.balance = parseFloat(el.dataset.balance) || 0;
            } else {
                const meta = document.querySelector('meta[name="wallet-balance"]');
                if (meta) this.balance = parseFloat(meta.content) || 0;
            }
        },
        setBalance(val) {
            this.balance = parseFloat(val) || 0;
            const el = document.getElementById('wallet-balance');
            if (el) {
                el.dataset.balance = this.balance;
                el.textContent = '$' + this.balance.toFixed(2);
            }
            document.querySelectorAll('[data-wallet-balance]').forEach(el => {
                el.textContent = '$' + this.balance.toFixed(2);
            });
            const meta = document.querySelector('meta[name="wallet-balance"]');
            if (meta) meta.content = this.balance.toFixed(2);
        },
        deduct(amount) {
            this.setBalance(this.balance - amount);
        },
        add(amount) {
            this.setBalance(this.balance + amount);
        },
    });

    Alpine.data('formValidation', () => ({
        errors: {},
        touched: {},
        validate(field, value, rules = []) {
            this.touched[field] = true;
            for (const rule of rules) {
                const error = rule(value);
                if (error) {
                    this.errors[field] = error;
                    return;
                }
            }
            delete this.errors[field];
        },
        valid(field) {
            return this.touched[field] && !this.errors[field];
        },
        invalid(field) {
            return this.touched[field] && this.errors[field];
        },
        inputClass(field, base = null) {
            if (!this.touched[field]) return {};
            if (this.errors[field]) return {
                'form-input-error': true,
                'bg-red-50': true,
            };
            return {
                'form-input-success': true,
                'bg-green-50': true,
            };
        },
        selectClass(field) {
            return this.inputClass(field);
        },
        anyErrors() {
            return Object.keys(this.errors).length > 0;
        },
        isDirty(field) {
            return !!this.touched[field];
        },
    }));
});

window.validators = {
    required: (v) => (!v || String(v).trim() === '') ? 'This field is required' : '',
    email: (v) => v && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? 'Please enter a valid email address' : '',
    minLength: (min) => (v) => v && v.length < min ? `Must be at least ${min} characters` : '',
    maxLength: (max) => (v) => v && v.length > max ? `Must be ${max} characters or fewer` : '',
    numeric: (v) => v && isNaN(parseFloat(v)) ? 'Must be a number' : '',
    min: (min) => (v) => v && parseFloat(v) < min ? `Minimum value is ${min}` : '',
    max: (max) => (v) => v && parseFloat(v) > max ? `Maximum value is ${max}` : '',
    integer: (v) => v && !Number.isInteger(Number(v)) ? 'Must be a whole number' : '',
    fileRequired: (v) => !v || v.length === 0 ? 'Please upload a file' : '',
    url: (v) => v && !/^https?:\/\/.+/.test(v) ? 'Must be a valid URL (starting with http:// or https://)' : '',
};

window.addEventListener('notify', (e) => {
    Alpine.store('notifications').addToast(e.detail.message, e.detail.type || 'info');
});

window.addEventListener('cart-updated', () => {
    Alpine.store('cart').save();
});

Alpine.start();
