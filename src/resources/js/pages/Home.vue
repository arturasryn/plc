<template>
    <Header />

    <div class="w-6/12 px-10 mx-auto">

        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl">Issues</h1>
                <button class="bg-blue-600 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-400" @click="openCreate">Create</button>
            </div>
        </div>

        <Loader v-if="isLoading"/>
        <ul class="border-t mt-3 cursor-pointer">

            <li :class="`py-3 flex justify-between border-b text-gray-600`"
                v-for="(val, idx) in issues.data" :key="idx">
                <div><span class="bg-blue-100 text-xs mr-2 p-2" :class="`${val.tag_class}`">{{ val.type }}-{{ val.id }}</span> <span @click="openEdit(issues.data[idx])" >{{ val.title }}</span></div>
                <div style="min-width: 100px;" class="ml-auto text-right">
                    <button class="bg-green-400 mr-2 px-2 text-white font-bold rounded-md hover:bg-green-600" @click="openEdit(issues.data[idx])">✏️</button>
                    <button class="bg-red-400 px-2 text-white font-bold rounded-md hover:bg-red-600" @click="deleteIssue(val, idx)">🗑️</button>
                </div>
            </li>

        </ul>

        <button v-if="issues.next" @click="loadIssues(issues.next)" class="my-3 bg-blue-600 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-400">Load more</button>  
    </div>

    <IssueModal :selectedIssue="selectedIssue" :open="open" v-if="open" @close="close" />
</template>

<script>
import {ref, onMounted} from 'vue'
import {useRouter} from "vue-router";
import {request} from '../helper'
import Loader from '../components/Loader.vue';
import Replies from '../components/Replies.vue';
import Header from '../components/Header.vue';
import IssueModal from '../components/IssueModal.vue';

export default {
    components: {
        Loader,
        Replies,
        Header,
        IssueModal,
    },
    setup() {

    },
    data() {
        return {
            issues: {data: [], next: false},
            selectedIssue: {
                comments: [],
                type: 'task',
                status: 'in progress',
            },
            isLoading: true,
            open: false,
        }
    },
    mounted() {
        this.loadIssues();
    },
    methods: {
        async loadIssues(url = '/api/issues') {
            this.loadingStart();

            try {
                const req = await request('get', url);
                this.issues.data.push(...req.data.data);
                this.issues.next = req.data.next;
            } catch (e) {
                console.log(e);
            }

            this.loadingFinish();
        },
        async reloadIssues() {
            this.loadingStart();

            try {
                const req = await request('get', '/api/issues');
                this.issues = req.data
            } catch (e) {
                console.log(e);
            }

            this.loadingFinish();
        },
        async loadUsers() {
            this.loadingStart();

            try {
                const req = await request('get', '/api/users');
                this.users = req.data.data;
            } catch (e) {
                await this.$router.push('/');
            }

            this.loadingFinish();
        },
        async loadingStart() {
            this.isLoading = true;
        },
        async loadingFinish() {
            this.isLoading = false;
        },

        async openCreate() {
            this.selectedIssue = {
                isNew: true,
                comments: [],
                type: 'task',
                status: 'in progress',
            };
            this.open = true;
        },
        async openEdit(issue) {
            this.selectedIssue = issue;
            this.open = true;
        },
        async deleteIssue(issue, index) {
            this.loadingStart();

            if (window.confirm("Are you sure")) {
                try {
                    const req = await request('delete', `/api/issues/${issue.id}`)
                    if (req.data.message) {
                        this.issues.data.splice(index, 1);
                    }
                } catch (e) {
                    console.log(e);
                }
            }

            this.loadingFinish();
        },
        async close() {
            this.open = false;
            this.reloadIssues();
        },
    },
}
</script>