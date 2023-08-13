<template>
    <div class="w-6/12 px-10 mt-5 mx-auto">
    <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-3">
        
                <router-link class="bg-gray-600 text-sm text-white px-4 py-2 rounded-md hover:bg-gray-400" to="/home">Issues</router-link>
                <router-link class="bg-gray-600 text-sm text-white px-4 py-2 rounded-md hover:bg-gray-400" to="/logs">Logs</router-link>
                           
            </div>
            <span class="capitalize">Welcome, {{ user && user.name }}, <button class="text-orange-500 underline hover:no-underline rounded-md" @click="handleLogout">Logout</button></span>
        </div>
    </div>
</template>

<script>
import {request} from '../helper'

export default {
    setup() {

    },
    data() {
        return {
            user: {},
        }
    },
    mounted() {
        this.loadUser();
    },
    methods: {
        async loadUser() {
            try {
                const req = await request('get', '/api/user');
                this.user = req.data;
            } catch (e) {
                await this.$router.push('/');
            }
        },
        async handleLogout() {
            localStorage.removeItem('APP_DEMO_USER_TOKEN');
            await this.$router.push('/');
        },
    },
}
</script>