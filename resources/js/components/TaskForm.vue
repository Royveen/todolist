<template>
    <div class="task-form">

        <div class="form-group ">
            <div class="input-group">
                <textarea type="text" cols=1 rows=1 placeholder="Description" v-model="task.description"
                    class="form-control" id="desc"></textarea>
                <div class="input-group-append">
                    <!-- <input type="datetime-local" v-model = "task.date" class="form-control" id="dateBox" > -->
                    <date-picker v-model="task.date" :config="$root.options"></date-picker>
                </div>
            </div>

        </div>

        <div class="button-box">
            <button type="button" @click="submitTask()" v-if="!taskObject" class="btn btn-primary"><i
                    class="fas fa-check-circle"></i></button>
            <button type="button" @click="editTask()" v-if="taskObject" class="btn btn-primary"><i
                    class="fas fa-edit"></i></button>
            <button type="button" @click="closeTaskForm()" class="btn btn-danger"><i class="fas fa-times"></i></button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['taskObject', 'defaultDate'],
        data() {
            return {
                task: {
                    description: '',
                    date: this.defaultDate ? this.defaultDate : '',
                    date_completed: null,
                    status: "pending"
                },
            }
        },
        created() {
            if (this.taskObject) {
                this.task.description = this.taskObject.description;
                this.task.date = this.taskObject.date;
            }
        },
        methods: {
            submitTask: function () {
                fetch('api/tasks', {
                        method: 'post',
                        body: JSON.stringify(this.task),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'content-type': 'application/json'
                        }
                    }).then(res => res.json())
                    .then(data => {
                        if (this.formatDate(data.date) == this.formatDate(this.defaultDate)) {
                            this.$emit('task-done', data.date);
                        } else {
                            this.$root.$emit('task-done-all', data.date);
                            this.closeTaskForm();
                        }
                    })
                    .catch(err => console.log(err));
            },
            editTask: function () {
                fetch('api/tasks/' + this.taskObject.id, {
                        method: 'put',
                        body: JSON.stringify(this.task),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'content-type': 'application/json'
                        }
                    }).then(res => res.json())
                    .then(data => {
                        if (this.formatDate(data.date) == this.formatDate(this.defaultDate)) {
                            this.$emit('task-done', data.date);
                        } else {
                            this.$emit('task-done', this.defaultDate);
                            this.$root.$emit('task-done-all', data.date);
                        }
                    })
                    .catch(err => console.log(err));
            },
            formatDate($date) {
                return moment($date).format('YYYY-MM-DD');
            },
            closeTaskForm: function () {
                this.task = null;
                this.$emit('task-done', this.task);
            }
        }
    }
</script>