<div class="flex items-center space-x-2 mt-2">
    <select id="action-select"
        x-data
        @change="handleAction($event.target.value)"
        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-300 focus:border-blue-500">
        <option value="">Select an action</option>
        <option value="generateKeywords">🔍 Generate Keywords</option>  <option value="generate_items">📑 Generate Items</option>
    </select>
</div>

<script>
    function handleAction(action) {
        if (!action) return;

        Livewire.emit(action); // ✅ Calls Livewire method dynamically
    }
</script>