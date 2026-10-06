<div x-data="{
        toasts: [],
        add(detail) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, variant: detail.variant ?? 'primary', text: detail.text });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) {
            this.toasts = this.toasts.filter((toast) => toast.id !== id);
        },
    }" x-on:toast.window="add($event.detail)" class="toast toast-end z-50">
    <template x-for="toast in toasts" :key="toast.id">
        <div role="alert" class="alert" :class="{
            'border-primary bg-primary text-primary-content': toast.variant === 'primary',
            'alert-success': toast.variant === 'success',
            'alert-error': toast.variant === 'error',
            'alert-warning': toast.variant === 'warning',
            'alert-info': toast.variant === 'info',
        }">
            <span x-text="toast.text"></span>
        </div>
    </template>
</div>