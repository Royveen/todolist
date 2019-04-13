<template>
    <div class="task-options">
        <ul class="list-group">
            <li class="list-group-item " @click="activeTab = 'Today'" :class="{ 'active' : (activeTab == 'Today') }">Today</li>
            <li class="list-group-item" @click="activeTab = 'Tomorrow'" :class="{ 'active' : (activeTab == 'Tomorrow') }">Tomorrow</li>
            <li class="list-group-item" @click="activeTab = 'Next 7'" :class="{ 'active' : (activeTab == 'Next 7') }">Next 7 Days</li>
        </ul>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                activeTab : 'Today'
            }
        }
    }
</script>