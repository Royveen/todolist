<template>
    <div :id="'accordion-' + fetchDate " class="task-lists">
        <div class="card">
            <div class="card-header" v-if="!activeTaskAdd">
                <button class="btn btn-link" data-toggle="collapse" :data-target="'#taskList-' + fetchDate"
                    aria-expanded="true" aria-controls="collapseOne">
                    <h5 v-if="listStatus!='completed'">{{dayName}}</h5>
                    <h5 v-if="listStatus=='completed'">Completed Tasks</h5>
                </button>
                <a href='javascript:void(0)' v-if="!activeTaskAdd && (listStatus!='completed')" @click="openTaskForm()"><i
                        class="fas fa-plus-circle"></i>
                </a>

            </div>
            <div class="card-header" v-if="activeTaskAdd">
                <div class="task-add">
                    <task-form :defaultDate="dateToFetch" :taskObject="this.taskEditObject"
                        v-on:task-done="editTaskInList($event)" v-on:fetch-task="fetchTasks($event)"> </task-form>
                </div>
            </div>
            <div :id="'taskList-' + fetchDate" :class="'collapse '+ showList" :data-parent="'#accordion-' + fetchDate ">
                <div class="card-body">
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Description</th>
                                <th scope="col" v-if="listStatus=='completed'">Date Completed</th>
                                <th scope="col" v-if="listStatus!='completed'">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(task,i) in list" v-bind:key="task.id">
                                <td>{{i+1}}</td>
                                <td>{{task.description}}</td>
                                <td v-if="listStatus=='completed'">{{task.date_completed}} </td>
                                <td v-if="listStatus!='completed'">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"> <a title="Edit" href="javascript:void(0)"
                                                @click="editTask(task, i)"><i class="fas fa-edit"></i></a></li>
                                        <li class="list-inline-item"> <a title="Mark Complete" href="javascript:void(0)"
                                                @click="updateStatus(task.id,i)"><i class="fas fa-tasks"></i></a></li>
                                        <li class="list-inline-item"> <a title="Delete" href="javascript:void(0)"
                                                @click="deleteTask(task.id,i)"><i class="fas fa-trash-alt"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['dateToFetch', 'listStatus', 'showList'],
        mounted() {
            this.$root.$on('task-done-all', (data) => {
                if (data) {
                    if (this.formatDate(data) === this.fetchDate) {
                        this.fetchTasks(this.formatDate(data));
                    }
                }
            })
        },
        data() {
            return {
                activeTaskAdd: false,
                search: '',
                list: [],
                taskEditObject: null,
                fetchDate: this.formatDate(this.dateToFetch),
                dayName: moment(this.dateToFetch).format('dddd, MMM DD, YYYY')
            }
        },
        watch: {
            dateToFetch: function (newVal, oldVal) {
                this.list = [];
                this.fetchDate = this.formatDate(this.dateToFetch);
                if (newVal) {
                    this.dayName = moment(newVal).format('dddd, MMM DD, YYYY')
                    this.fetchTasks(this.formatDate(newVal));
                }
            },
            listStatus: function (newVal, oldVal) {
                this.list = [];
                if (newVal) {
                    this.fetchTasks(this.listStatus);
                }
            }
        },
        created() {
            if (!this.listStatus)
                this.fetchTasks(this.fetchDate);
            else
                this.fetchTasks(this.listStatus);
        },
        methods: {
            fetchTasks($day) {
                fetch('api/tasks/' + $day)
                    .then(res => res.json())
                    .then(data => {
                        this.list = [];
                        data.map((task) => this.list.push(task));
                    })
            },
            formatDate($date) {
                return moment($date).format('YYYY-MM-DD');
            },
            editTask($task, $index) {
                this.taskEditObject = $task;
                this.activeTaskAdd = true;
            },
            editTaskInList($data) {
                this.editTaskIndex = null;
                this.closeTaskForm($data);
            },
            updateStatus($id, $index) {
                let taskToUpdate = this.list[$index];
                taskToUpdate.status = 'completed';
                taskToUpdate.date_completed = moment(new Date()).format(this.$root.options.format);
                fetch('api/tasks/' + $id, {
                        method: 'put',
                        body: JSON.stringify(taskToUpdate),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'content-type': 'application/json'
                        }
                    }).then(res => res.json())
                    .then(data => {
                        this.list.splice($index, 1);
                    })
                    .catch(err => console.log(err.json()));
            },
            deleteTask($id, $index) {
                fetch('api/tasks/' + $id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'content-type': 'application/json'
                        }
                    }).then(res => res)
                    .then(data => {
                        if (data.ok)
                            this.list.splice($index, 1);
                    })
                    .catch(err => console.log(err));
            },
            openTaskForm: function () {
                this.activeTaskAdd = true;
            },

            closeTaskForm: function (data) {
                this.activeTaskAdd = false;
                this.taskEditObject = null;
                if (data)
                    this.fetchTasks(this.formatDate(data));
            }

        }

    }
</script>