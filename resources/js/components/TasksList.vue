<template>
    <div class="task-lists">
        <div class="header">
            <a href='#' @click="addTasks()">Add Task</a>
            <div class="search">
                <input type="text" v-model="search" class="form-control" placeholder="search">
            </div>
        </div>
        <div class="task-add" v-if="activeTaskAdd">
            <task-form v-on:task-done="closeTask($event)"> </task-form>
        </div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
                <tr v-for="task , i in list">
                    <td>{{i+1}}</th>
                    <td>{{task.title}}</td>
                    <td>{{task.description}}</td>
                    <td> 
                        <ul class="list-inline">
                            <li class="list-inline-item"> <a href="">Completed</a></li>
                            <li class="list-inline-item"> <a href="">Delayed</a></li>
                        </ul>
                    </td>
                </tr>
        </tbody>
    </table>    
        

    </div>
</template>
<script>
    export default {
        mounted() {
           
            console.log("component mounted")
        },
        data() {
            return {
                activeTaskAdd: false,
                search: '',
                list : [],
            }
        },
        methods: {

            addTasks: function() {
                
                this.activeTaskAdd = true;
            },

            closeTask: function(data) {
                this.activeTaskAdd = false;
                this.list.push(data);
                console.log(data);
            }

        }

    }
</script>