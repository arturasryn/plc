<template>
    <Header />

    <div class="w-6/12 px-10 mx-auto">

        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl">Logs</h1>
            </div>
        </div>

        <ul class="border-t mt-3 cursor-pointer">

            <li :class="`py-3 flex justify-between border-b text-gray-600`"
                v-for="(val, idx) in logs.data" :key="idx">

                <div>
                <div><b>{{ val.user.name }}</b> {{ val.action }} <u @click="openIssue(val.actionable)">{{ val.actionable ? val.actionable.title : '' }}</u></div>
                <div v-if="val.action == 'updated'">
                    <div v-for="(change, key) in val.changes">
                        <div v-if="key != 'updated_at'">change {{ key }} from <b class="bg-gray-300 my-1 p-1 text-xs inline-block">{{ change.original }}</b> to <b class="bg-gray-300 my-1 p-1 text-xs inline-block">{{ change.changes }}</b></div>
                        <div v-if="key == 'updated_at'">updated at {{ change.changes }}</div>
                    </div>
                </div>

                </div>
            </li>

        </ul>

        <button v-if="logs.next" @click="loadLogs(logs.next)" class="my-3 bg-blue-600 text-sm text-white px-4 py-2 rounded-md hover:bg-blue-400">Load more</button>  

    </div>

    <IssueModal :selectedIssue="selectedIssue" :open="open" v-if="open" @close="close" />

</template>

<script>
import {request} from '../helper'
import Header from '../components/Header.vue';
import IssueModal from '../components/IssueModal.vue';

export default {
    components: {
        Header,
        IssueModal,
    },
    setup() {

    },
    data() {
        return {
            logs: {data: []},
            open: false,
        }
    },
    mounted() {
        this.loadLogs();
    },
    methods: {
        async loadLogs(url = '/api/logs', append = true) {
            try {
                const req = await request('get', url);
                if(append) {
                    this.logs.data.push(...req.data.data);
                } else {
                    this.logs.data = req.data.data;

                }
                this.logs.next = req.data.next;
            } catch (e) {
                console.log(e);
            }
        },
        async openIssue(issue) {
            this.selectedIssue = issue;
            this.open = true;
        },
        async close() {
            this.loadLogs('/api/logs', false);
            this.open = false;
        },
    },
}
</script>