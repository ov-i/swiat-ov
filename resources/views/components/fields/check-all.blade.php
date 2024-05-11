<div x-data="checkAll">
    <x-input x-ref="checkbox" @change="handleCheck" type="checkbox" class="rounded border-gray-300 shadow" />
</div>

@script
    <script>
        Alpine.data('checkAll', () => ({
            init() {
                this.$wire.$watch('selectedItemIds', () => {
                    this.updateCheckAllState()
                })

                this.$wire.$watch('itemIdsOnPage', () => {
                    this.updateCheckAllState()
                })
            },

            updateCheckAllState() {
                if (this.pageIsSelected()) {
                    this.$refs.checkbox.checked = true
                    this.$refs.checkbox.indeterminate = false
                } else if (this.pageIsEmpty()) {
                    this.$refs.checkbox.checked = false
                    this.$refs.checkbox.indeterminate = false
                } else {
                    this.$refs.checkbox.checked = false
                    this.$refs.checkbox.indeterminate = true
                }
            },

            pageIsSelected() {
                return this.$wire.itemIdsOnPage.every((id) => this.$wire.selectedItemIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedItemIds.length === 0
            },

            /** @param { InputEvent } event */
            handleCheck(event) {
                event.target.checked ? this.checkAll() : this.uncheckAll() 
            },

            checkAll() {
                this.$wire.itemIdsOnPage.forEach(id => {
                    if (this.$wire.selectedItemIds.includes(id)) return

                    this.$wire.selectedItemIds.push(id)
                })
            },

            uncheckAll() {
                this.$wire.selectedItemIds = []
            },
        }));
    </script>
@endscript