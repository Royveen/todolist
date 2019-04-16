<template>
<div class="row">
                <div class="col-md-4 task-options">
                    <ul class="list-group">
                        <li class="list-group-item " @click="changeTab('Today')" :class="{ 'active' : (activeTab == 'Today') }">Today</li>
                        <li class="list-group-item" @click="changeTab('Tomorrow')" :class="{ 'active' : (activeTab == 'Tomorrow') }">Tomorrow</li>
                        <li class="list-group-item" @click="changeTab('Next 7')" :class="{ 'active' : (activeTab == 'Next 7') }">Next 7 Days</li>
                        <li class="list-group-item" @click="changeTab('Completed')" :class="{ 'active' : (activeTab == 'Completed') }">Completed</li>
                </ul>
                </div>
                <div class="col-md-6">
                    <div v-if="activeTab != 'Next 7'">
                        <task-list v-if="dateForList" :dateToFetch="dateForList"></task-list>
                    </div>
                    
                    <div v-if="activeTab == 'Next 7' && nextDates.length > 0">
                        <div class="nextDays" v-for="date,i in nextDates" v-bind:key="date">
                        <task-list :dateToFetch="date"></task-list>
                        </div>
                    </div>
                </div>
</div>
</template>
<script>
    export default {
        data() {
            return {
                activeTab : 'Today',
                todayDate: moment(new Date()).format('YYYY-MM-DD'),
                tomorrowDate: moment(new Date()).add(1,'days').format('YYYY-MM-DD'),
                dateForList:null,
                nextDates:[],
            }
        },
        created() {
            this.dateForList = this.todayDate;
        },
        methods:{
            nextWeekDates:function(date) {
                    var i = 1;
                    var dates = [];
                    while(i<=7) {
                        dates.push(moment(date).add(i,'days').format('YYYY-MM-DD'));
                        ++i;
                    }
                    return dates;
                },
        changeTab($tabName) {
            this.activeTab = $tabName;
            switch ($tabName) {
                case 'Today':
                    this.dateForList = this.todayDate;
                    break;
                case 'Tomorrow':
                    this.dateForList = this.tomorrowDate;
                    break;
                 case 'Next 7':
                 if(this.nextDates.length == 0 )
                    this.nextDates = this.nextWeekDates(this.todayDate);
                break;
                case 'Completed':
                 this.dateForList = 'completed'
                break;
                default:
                    break;
            }
        },
        }
    }
</script>