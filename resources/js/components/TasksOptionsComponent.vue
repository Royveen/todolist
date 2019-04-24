<template>
    <div class="row">
        <div class="col-md-4 task-options">
            <ul class="list-group">
                <li class="list-group-item " @click="changeTab('Today')" :class="{ 'active' : (activeTab == 'Today') }">
                    Today</li>
                <li class="list-group-item" @click="changeTab('Tomorrow')"
                    :class="{ 'active' : (activeTab == 'Tomorrow') }">Tomorrow</li>
                <li class="list-group-item" @click="changeTab('Next 7')"
                    :class="{ 'active' : (activeTab == 'Next 7') }">Next 7 Days</li>
                <li class="list-group-item" @click="changeTab('Completed')"
                    :class="{ 'active' : (activeTab == 'Completed') }">Completed</li>
            </ul>
        </div>
        <div class="col-md-6">
            <div v-if="activeTab != 'Next 7'">
                <task-list :dateToFetch="dateForList" :listStatus="status" showList="show"></task-list>
            </div>

            <div v-if="activeTab == 'Next 7' && nextDates.length > 0">
                <div class="nextDays" v-for="date,i in nextDates" v-bind:key="date">
                    <task-list :dateToFetch="date" :listStatus="status" showList="no"></task-list>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                activeTab: 'Today',
                todayDate: moment(new Date()).format(this.$root.options.format),
                tomorrowDate: moment(new Date()).add(1, 'days').format(this.$root.options.format),
                dateForList: null,
                nextDates: [],
                status: null,
            }
        },
        created() {
            this.dateForList = this.todayDate;
        },
        methods: {
            nextWeekDates: function (date) {
                var i = 2;
                var dates = [];
                while (i <= 8) {
                    dates.push(moment(date).add(i, 'days').format(this.$root.options.format));
                    ++i;
                }
                return dates;
            },
            changeTab($tabName) {
                this.activeTab = $tabName;
                switch ($tabName) {
                    case 'Today':
                        this.dateForList = this.todayDate;
                        this.status = null;
                        break;
                    case 'Tomorrow':
                        this.dateForList = this.tomorrowDate;
                        this.status = null;
                        break;
                    case 'Next 7':
                        if (this.nextDates.length == 0)
                            this.nextDates = this.nextWeekDates(new Date());
                        this.status = null;
                        break;
                    case 'Completed':
                        this.dateForList = null;
                        this.status = 'completed';
                        break;
                    default:
                        break;
                }
            },
        }
    }
</script>