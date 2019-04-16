<template>
    <div class="task-lists">
        <div class="header" v-if="dateToFetch!='completed'">
            <a href='javascript:void(0)' v-if="!activeTaskAdd" @click="openTaskForm()">Add Task</a>
            <small>{{dayName}}</small>
            <!-- <div class="search">
                <input type="text" v-model="search" class="form-control" placeholder="search">
            </div> -->
        </div>
        <div class="task-add" v-if="activeTaskAdd">
            <task-form :defaultDate="dateToFetch" :taskObject="this.taskEditObject" v-on:task-done="closeTaskForm($event)" v-on:task-edited="editTaskInList($event)"> </task-form>
        </div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col" v-if="dateToFetch=='completed'">Date Completed</th>
            <th scope="col" v-if="dateToFetch!='completed'">Action</th>
            </tr>
        </thead>
        <tbody>
                <tr v-for="task , i in list" v-bind:key="task.id">
                    <td>{{i+1}}</td>
                    <td>{{task.title}}</td>
                    <td>{{task.description}}</td>
                    <td v-if="dateToFetch=='completed'">{{formatDate(task.date)}} </td>
                    <td v-if="dateToFetch!='completed'"> 
                        <ul class="list-inline" >
                            <li class="list-inline-item"> <a href="javascript:void(0)" @click="editTask(task, i)">Edit</a></li>
                            <li class="list-inline-item"> <a href="javascript:void(0)" @click="updateStatus(task.id,i)">Completed</a></li>
                            <li class="list-inline-item"> <a href="javascript:void(0)" @click="deleteTask(task.id,i)">Delete</a></li>
                        </ul>
                    </td>
                </tr>
        </tbody>
    </table>    
        

    </div>
</template>
<script>
    export default {
        props:['dateToFetch'],
        data() {
            return {
                activeTaskAdd: false,
                search: '',
                list : [],
                taskEditObject: null,
                fetchDate: this.formatDate(this.dateToFetch),
                editTaskIndex:null,
                dayName: moment(this.dateToFetch).format('dddd, MMM DD, YYYY')
            }
        },
        watch: { 
                dateToFetch: function(newVal, oldVal) {
                    this.list = []; 
                    this.fetchTasks(newVal);
                }
        },
        created() {
                this.fetchTasks(this.fetchDate);
        },
        methods: {
            fetchTasks($day) {
                fetch('api/tasks/' + $day)
                .then(res=>res.json())
                .then(data => {
                    data.map((task)=> this.list.push(task));
                })
            },
            formatDate($date) {
                return moment($date).format('YYYY-DD-MM');
            },
            editTask($task,$index) {
                this.taskEditObject = $task;
                this.activeTaskAdd = true;
                this.editTaskIndex = $index;
            },
            editTaskInList($data) {
              this.list.splice(this.editTaskIndex,1,$data);
              this.editTaskIndex = null;
              this.closeTaskForm(null); 
            },
            updateStatus($id, $index) {
                let taskToUpdate = this.list[$index];
                taskToUpdate.status = 'completed';         
                fetch('api/tasks/'+$id, {
                    method: 'put',
                    body: JSON.stringify(taskToUpdate),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'content-type': 'application/json'
                    }
                    }).then(res=>res.json())
                    .then(data => {
                        this.list.splice($index,1);
                    })
                    .catch(err => console.log(err));
            },
            openTaskForm: function() {
                this.activeTaskAdd = true;
            },

            closeTaskForm: function(data) {
                this.activeTaskAdd = false;
                this.taskEditObject = null;
                if(data && data.title)
                    this.fetchTasks(this.fetchDate);
            }

        }

    }
</script>