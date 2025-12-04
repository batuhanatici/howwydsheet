document.addEventListener('alpine:init', () => {
    Alpine.data('howwydSheet', (config = {}) => ({
        // Configuration
        initialSize: config.initialSize || '50%',
        minSize: config.minSize || '25%',
        maxSize: config.maxSize || '100%',
        lockable: config.lockable || false,
        fullscreenOnInit: config.fullscreenOnInit || false,
        breakpoints: config.breakpoints || { min: 25, mid: 50, max: 75 },

        // State
        isVisible: false,
        currentHeight: 0,
        isDragging: false,
        startY: 0,
        startHeight: 0,
        isFull: false,
        rafId: null,

        init() {
            // Set initial height
            this.currentHeight = this.parseSize(this.initialSize);
            if (this.fullscreenOnInit) {
                this.currentHeight = 100;
                this.isFull = true;
            }
            
            // Watch for visibility changes to handle body scroll
            this.$watch('isVisible', value => {
                if (value) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            });
        },

        show() {
            this.isVisible = true;
            
            if (this.fullscreenOnInit) {
                this.currentHeight = 100;
                this.isFull = true;
                return;
            }

            // Reset height if not locked
            if (!this.lockable && !this.isFull) {
                this.currentHeight = this.parseSize(this.initialSize);
            }
        },

        hide(force = false) {
            if (this.lockable && !force) return;
            this.isVisible = false;
            this.isFull = false;
        },

        toggle() {
            this.isVisible ? this.hide() : this.show();
        },

        // Drag Handlers
        startDrag(e) {
            this.isDragging = true;
            this.startY = e.touches ? e.touches[0].clientY : e.clientY;
            this.startHeight = this.currentHeight;
            // Prevent selection during drag
            document.body.style.userSelect = 'none';
            
            // If starting drag from fullscreen, we must allow height to change
            // The inline style will override the class, but we need to ensure logic allows it
        },

        onDrag(e) {
            if (!this.isDragging) return;
            
            // Use requestAnimationFrame for smoother updates
            if (this.rafId) cancelAnimationFrame(this.rafId);

            this.rafId = requestAnimationFrame(() => {
                const currentY = e.touches ? e.touches[0].clientY : e.clientY;
                const deltaY = this.startY - currentY;
                const deltaPercent = (deltaY / window.innerHeight) * 100;
                
                let newHeight = this.startHeight + deltaPercent;
                
                // Elasticity for locked mode: Allow dragging below 0 but with resistance
                if (this.lockable) {
                    // Apply resistance if dragging down (newHeight < startHeight)
                    if (newHeight < this.startHeight) {
                        const diff = this.startHeight - newHeight;
                        newHeight = this.startHeight - (diff * 0.5); // 50% resistance
                    }
                } else {
                    // Normal constraints
                    newHeight = Math.max(0, Math.min(100, newHeight));
                }
                
                this.currentHeight = newHeight;
            });
        },

        endDrag() {
            if (!this.isDragging) return;
            this.isDragging = false;
            if (this.rafId) cancelAnimationFrame(this.rafId);
            
            // Restore selection
            document.body.style.userSelect = '';

            // Locked mode snap back
            if (this.lockable) {
                this.currentHeight = this.parseSize(this.initialSize);
                return;
            }

            // Snap logic
            if (this.currentHeight > this.breakpoints.max) {
                this.currentHeight = 100;
                this.isFull = true;
            } else if (this.currentHeight < this.breakpoints.min) {
                this.hide();
            } else {
                this.currentHeight = this.parseSize(this.initialSize);
                this.isFull = false;
            }
        },

        // Helpers
        parseSize(size) {
            if (typeof size === 'number') return size;
            if (size.endsWith('%')) return parseFloat(size);
            if (size.endsWith('px')) return (parseFloat(size) / window.innerHeight) * 100;
            return 50;
        },

        // Computed styles
        get sheetStyle() {
            return `height: ${this.currentHeight}vh; transition: ${this.isDragging ? 'none' : 'height 0.3s cubic-bezier(0.2, 0.8, 0.2, 1)'}; touch-action: none;`;
        }
    }));
});