<x-filament-panels::page>
    <div class="space-y-3" id="property-cards-table-2-wrapper">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            يمكنك ترتيب الأعمدة بالسحب والإفلات من أيقونة السحب الصغيرة بجانب اسم العمود.
        </p>

        {{ $this->table }}
    </div>

    @once
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', initPropertyCardsColumnsReorder);
                document.addEventListener('livewire:navigated', initPropertyCardsColumnsReorder);

                function initPropertyCardsColumnsReorder() {
                    const wrapper = document.getElementById('property-cards-table-2-wrapper');
                    if (!wrapper) return;

                    const storageKey = 'property-cards-table-2-column-order';

                    const setupTable = () => {
                        const table = wrapper.querySelector('table');
                        const headRow = table?.querySelector('thead tr');
                        if (!table || !headRow) return;

                        if (table.dataset.columnsDragReady === '1') {
                            return;
                        }

                        table.dataset.columnsDragReady = '1';

                        const getHeaders = () =>
                            Array.from(headRow.children).filter((cell) => cell.tagName === 'TH');

                        const getColumnId = (headerCell, index) => {
                            const clickable = headerCell.querySelector('button,[wire\\:click],a');
                            const text = (
                                clickable?.textContent ||
                                headerCell.textContent ||
                                headerCell.getAttribute('aria-label') ||
                                headerCell.getAttribute('title') ||
                                ''
                            ).trim().replace(/\s+/g, ' ');

                            return headerCell.getAttribute('data-column-id') || text || `column-${index}`;
                        };

                        const persistCurrentOrder = () => {
                            const order = getHeaders().map((cell, index) => getColumnId(cell, index));
                            localStorage.setItem(storageKey, JSON.stringify(order));
                        };

                        const moveColumn = (fromIndex, toIndex, persist = true) => {
                            if (fromIndex === toIndex || fromIndex < 0 || toIndex < 0) return;

                            const rows = table.querySelectorAll('tr');

                            rows.forEach((row) => {
                                const cells = Array.from(row.children);
                                if (fromIndex >= cells.length || toIndex >= cells.length) return;

                                const movingCell = cells[fromIndex];
                                const targetCell = cells[toIndex];

                                if (!movingCell || !targetCell) return;

                                if (fromIndex < toIndex) {
                                    row.insertBefore(movingCell, targetCell.nextSibling);
                                } else {
                                    row.insertBefore(movingCell, targetCell);
                                }
                            });

                            decorateHeaders();

                            if (persist) {
                                persistCurrentOrder();
                            }
                        };

                        const applySavedOrder = () => {
                            const raw = localStorage.getItem(storageKey);
                            if (!raw) return;

                            let savedOrder = [];

                            try {
                                savedOrder = JSON.parse(raw);
                            } catch {
                                return;
                            }

                            if (!Array.isArray(savedOrder) || !savedOrder.length) return;

                            savedOrder.forEach((savedId, desiredIndex) => {
                                const headers = getHeaders();
                                const currentIndex = headers.findIndex((header, index) => getColumnId(header, index) === savedId);

                                if (currentIndex >= 0 && currentIndex !== desiredIndex) {
                                    moveColumn(currentIndex, desiredIndex, false);
                                }
                            });

                            persistCurrentOrder();
                        };

                        const clearDropIndicators = () => {
                            getHeaders().forEach((header) => {
                                header.classList.remove(
                                    'ring-2',
                                    'ring-primary-500',
                                    'ring-inset',
                                    'bg-primary-50',
                                    'dark:bg-primary-900/20'
                                );
                            });
                        };

const createDragHandle = (headerCell) => {
    const handle = document.createElement('span');
    handle.className = 'column-drag-handle';
    handle.setAttribute('draggable', 'true');
    handle.setAttribute('title', 'اسحب لإعادة ترتيب العمود');
    handle.setAttribute('aria-label', 'اسحب لإعادة ترتيب العمود');

    handle.textContent = '⋮⋮';

    handle.style.display = 'inline-flex';
    handle.style.alignItems = 'center';
    handle.style.justifyContent = 'center';
    handle.style.marginInlineStart = '6px';
    handle.style.fontSize = '12px';
    handle.style.lineHeight = '1';
    handle.style.color = '#9ca3af';
    handle.style.cursor = 'grab';
    handle.style.userSelect = 'none';
    handle.style.verticalAlign = 'middle';
    handle.style.flexShrink = '0';

    handle.addEventListener('mouseenter', () => {
        handle.style.color = '#2563eb';
    });

    handle.addEventListener('mouseleave', () => {
        handle.style.color = '#9ca3af';
    });

    handle.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
    });

    handle.addEventListener('mousedown', (event) => {
        event.stopPropagation();
    });

    handle.addEventListener('dragstart', (event) => {
        const currentIndex = getHeaders().indexOf(headerCell);

        event.stopPropagation();
        event.dataTransfer?.setData('text/plain', String(currentIndex));

        if (event.dataTransfer) {
            event.dataTransfer.effectAllowed = 'move';
        }

        headerCell.classList.add('opacity-60');
        handle.style.cursor = 'grabbing';
    });

    handle.addEventListener('dragend', () => {
        headerCell.classList.remove('opacity-60');
        handle.style.cursor = 'grab';
        clearDropIndicators();
    });

    return handle;
};

                        const decorateHeaders = () => {
                            getHeaders().forEach((headerCell, index) => {
                                if (!headerCell.getAttribute('data-column-id')) {
                                    headerCell.setAttribute('data-column-id', getColumnId(headerCell, index));
                                }

                                headerCell.classList.add('relative', 'select-none');
                                headerCell.querySelector('.column-drag-handle')?.remove();

                                const clickableTarget = headerCell.querySelector('button, a, [wire\\:click]');

                                const handle = createDragHandle(headerCell);

                                if (clickableTarget && clickableTarget !== headerCell) {
                                    clickableTarget.classList.add('inline-flex', 'items-center');

                                    const existingHandle = clickableTarget.querySelector('.column-drag-handle');
                                    if (!existingHandle) {
                                        clickableTarget.appendChild(handle);
                                    }
                                } else {
                                    headerCell.appendChild(handle);
                                }

                                headerCell.addEventListener('dragover', (event) => {
                                    event.preventDefault();

                                    if (event.dataTransfer) {
                                        event.dataTransfer.dropEffect = 'move';
                                    }
                                });

                                headerCell.addEventListener('dragenter', (event) => {
                                    event.preventDefault();
                                    clearDropIndicators();

                                    headerCell.classList.add(
                                        'ring-2',
                                        'ring-primary-500',
                                        'ring-inset',
                                        'bg-primary-50',
                                        'dark:bg-primary-900/20'
                                    );
                                });

                                headerCell.addEventListener('dragleave', (event) => {
                                    if (!headerCell.contains(event.relatedTarget)) {
                                        headerCell.classList.remove(
                                            'ring-2',
                                            'ring-primary-500',
                                            'ring-inset',
                                            'bg-primary-50',
                                            'dark:bg-primary-900/20'
                                        );
                                    }
                                });

                                headerCell.addEventListener('drop', (event) => {
                                    event.preventDefault();

                                    const fromIndex = Number(event.dataTransfer?.getData('text/plain'));
                                    const toIndex = getHeaders().indexOf(headerCell);

                                    clearDropIndicators();

                                    if (!Number.isNaN(fromIndex) && toIndex >= 0) {
                                        moveColumn(fromIndex, toIndex);
                                    }
                                });
                            });
                        };

                        decorateHeaders();
                        applySavedOrder();
                    };

                    setupTable();

                    if (wrapper.dataset.columnsObserverReady === '1') {
                        return;
                    }

                    wrapper.dataset.columnsObserverReady = '1';

                    const observer = new MutationObserver(() => {
                        const table = wrapper.querySelector('table');

                        if (table && table.dataset.columnsDragReady !== '1') {
                            setupTable();
                        }
                    });

                    observer.observe(wrapper, {
                        childList: true,
                        subtree: true,
                    });
                }
            </script>
        @endpush
    @endonce
</x-filament-panels::page>