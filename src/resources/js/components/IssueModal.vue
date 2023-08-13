<template>
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed bg-gray-700 top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Issue
                </h3>
                <button type="button" @click="close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="defaultModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900e">Title</label>
                        <input type="text" :disabled="selectedIssue.trashed" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Title" v-model="selectedIssue.title" required>
                    </div>

                    <div>
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                        <select id="type" :disabled="selectedIssue.trashed" v-model="selectedIssue.type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option v-for="(val, idx) in types" :key="idx" :value="val">{{ val }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                        <select id="status" :disabled="selectedIssue.trashed" v-model="selectedIssue.status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option v-for="(val, idx) in statuses" :key="idx">{{ val }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">User</label>
                        <select id="user_id" :disabled="selectedIssue.trashed" v-model="selectedIssue.user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option v-for="(item, idx) in users" :key="item.id" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="tester_id" class="block mb-2 text-sm font-medium text-gray-900">Tester</label>
                        <select id="tester_id" :disabled="selectedIssue.trashed" v-model="selectedIssue.tester_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option v-for="(item, idx) in users" :key="item.id" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="performer_id" class="block mb-2 text-sm font-medium text-gray-900">Performer</label>
                        <select id="performer_id" :disabled="selectedIssue.trashed" v-model="selectedIssue.performer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option v-for="(item, idx) in users" :key="item.id" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>

                </div>

                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900e">Description</label>
                    <textarea id="description" :disabled="selectedIssue.trashed" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Description" v-model="selectedIssue.description" />
                </div>

                <div class="flex items-center py-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button v-if="!selectedIssue.trashed" @click="createOrUpdateIssue(selectedIssue)" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    <button @click="close" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                </div>

                <div v-if="!selectedIssue.isNew && !selectedIssue.trashed">
                    <div>
                        <div>Comments</div>
                        <div v-for="(comment, commentIndex) in comments" class="border border-gray-300 mt-3 p-3">
                            <div class="text-xs"><b>{{ comment.user.name }}</b></div>
                            <div>{{ comment.body }}</div>

                            <button type="button" @click="comment.openReply = true"  class="mt-3 text-gray-500 text-xs bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-3 py-2 hover:text-gray-900 focus:z-10">Reply</button>
                            <div v-if="comment.openReply" class="mt-3">
                                <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Leave a Comment</label>
                                <textarea id="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Comment" v-model="newReplyComment.body"></textarea>
                                <button type="button" @click="createReply(comments[commentIndex], newReplyComment)" class="mt-3 mr-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Submit</button>
                                <button @click="comment.openReply = false">Cancel</button>
                            </div>       
                            
                            <Replies :comment="comment" @load-replies="loadReplies" />

                        </div>
                        <button @click="loadComments(this.selectedIssue, commentsPagination.current_page + 1)" v-if="commentsPagination.next_page_url">Load more</button>
                    </div>
                    <div class="mt-3">
                        <!-- <div v-if="newComment.parent">
                            <div><b>Reply to</b></div>
                            <div>{{ newComment.parent.user.name }}</div>
                            <div>{{ newComment.parent.body }}</div>
                            <button class="text-xs text-red-300" @click="cancelReply">Cancel</button>
                        </div> -->
                        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Leave a Comment</label>
                        <textarea id="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Comment" v-model="newComment.body"></textarea>
                        <button type="button" @click="createComment(this.selectedIssue, newComment)" class="mt-3 mr-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Submit</button>
                        <button @click="close">Close</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>
</template>

<script>
import {ref} from 'vue'
import {request} from '../helper'
import Replies from './Replies.vue'

export default {
    props: ['selectedIssue', 'open'],
    components: {
        Replies,
    },
    data() {
        return {
            types: ['task', 'bug'], 
            statuses: ['paused', 'in progress', 'testing', 'completed'], 
            newComment: {},
            newReplyComment: {},
        }
    },
    setup(props) {
        const users = ref([]);
        const comments = ref([]);
        const commentsPagination = ref({});

        const loadComments = async function (issue, page = 1, append = true) {
            try {
                const req = await request('get', `/api/issues/${issue.id}/comments?page=${page}&perPage=2`);
                commentsPagination.value = req.data.data;

                if(append) comments.value = [...comments.value, ...req.data.data.data];
                else comments.value = req.data.data.data;
            } catch (e) {
                console.log(e);
            }
        };

        const loadUsers = async function () {
            try {
                const req = await request('get', '/api/users');
                users.value = req.data.data;
            } catch (e) {
                console.log(e);
            }
        };

        loadUsers();
        if(!props.selectedIssue.isNew && !props.selectedIssue.trashed) {
            loadComments(props.selectedIssue);
        }

        return {
            users,
            comments,
            commentsPagination,
            loadComments,
        };
    },
    mounted() {

    },
    methods: {
        async close() {
            this.$emit('close');
        },
        async createOrUpdateIssue(issue) {
            if(issue.isNew) {
                await this.createIssue(issue);
            } else {
                await this.saveIssue(issue);
            }
        },
        async createIssue (issue) {
            try {
                const req = await request('post', `/api/issues`, issue);
                this.close();
            } catch (e) {
                if(e.request && e.request.response) {
                    alert(JSON.parse(e.request.response).message);
                }
                console.log(e);
            }
        },
        async saveIssue (issue) {
            try {
                const req = await request('put', `/api/issues/${issue.id}`, issue)
                this.close(req.data);
            } catch (e) {
                if(e.request && e.request.response) {
                    alert(JSON.parse(e.request.response).message);
                }
                console.log(e);
            }
        },
        async loadReplies(comment) {
            try {
                if(!comment.replies) comment.replies = [];
                const req = await request('get', `/api/comments/${comment.id}/replies?from=${comment.replies.length}`);
                comment.replies = [...comment.replies, ...(req.data.data)];
            } catch (e) {
                console.log(e);
            }
        },
        async createComment(issue, comment) {
            try {
                const req = await request('post', `/api/issues/${issue.id}/comments`, comment);
                this.loadComments(issue, 1, false);
                this.newComment = {};
            } catch (e) {
                if(e.request && e.request.response) {
                    alert(JSON.parse(e.request.response).message);
                }
                console.log(e);
            }
        },
        async createReply(parentComment, newComment) {
            try {
                newComment.parent_id = parentComment.id;
                const req = await request('post', `/api/comments/${parentComment.id}/replies`, newComment);
                if(!parentComment.replies) parentComment.replies = [];
                parentComment.replies.push(req.data.data);
                newComment = {};
                parentComment.openReply = false;
            } catch (e) {
                if(e.request && e.request.response) {
                    alert(JSON.parse(e.request.response).message);
                }
                console.log(e);
            }
        },
    }
}
</script>