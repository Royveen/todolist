<template>
    <div class="task-lists">
    
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
            console.log('Component mounted.')
        },
        data() {
            return {
                list : [],
                tasks : {
                    title: '',
                    description: '',
                    date: ''
                }
            }
        },

    }
</script>