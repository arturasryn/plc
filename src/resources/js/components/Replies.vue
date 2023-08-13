<template>
    <div>
    <div v-for="(replyComment, replyIndex) in comment.replies" class="ml-5 mt-3 border border-gray-300 mt-3 p-3">
        <div class="text-xs"><b>{{ replyComment.user.name }}</b></div>
        <div>{{ replyComment.body }}</div>


        <button type="button" @click="replyComment.openReply = true"  class="mt-3 text-gray-500 text-xs bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-3 py-2 hover:text-gray-900 focus:z-10">Reply</button>
        <div v-if="replyComment.openReply" class="mt-2">
            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Leave a Comment</label>
            <textarea id="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Comment" v-model="newComment.body"></textarea>
            <button type="button" @click="createComment(comment.replies[replyIndex], newComment)" class="mt-3 mr-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Submit</button>
            <button @click="replyComment.openReply = false">Cancel</button>
        </div>

        <div>
            <Replies :comment="comment.replies[replyIndex]" @reply="reply" @load-replies="loadReplies" />
        </div>

    </div>

    <button class="ml-5 mt-3" @click="loadReplies(comment)" v-if="(comment.replies_count - (comment.replies ? comment.replies.length : 0)) > 0">Load more</button>
   
    </div>
</template>

<script>
import {request} from '../helper'

export default {
    props: {
        comment: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            openReply: false,
            newComment: {},
        }
    },
    methods: {
        reply(comment) {
            this.$emit('reply', comment)
        },
        loadReplies(comment) {
            this.$emit('load-replies', comment)
        },
        async createComment(parentComment, newComment) {
            console.log(parentComment);

            try {
                newComment.parent_id = parentComment.id;

                const req = await request('post', `/api/comments/${parentComment.id}/replies`, newComment);
                console.log(req.data.data);

                if(!parentComment.replies) parentComment.replies = [];
                parentComment.replies.push(req.data.data);
                newComment = {};
                parentComment.openReply = false;
            } catch (e) {
                if(e.request && e.request.response) {
                    alert(JSON.parse(e.request.response).message);
                }
                console.log(e);
                //await this.$router.push('/');
            }
        },
    }
}
</script>