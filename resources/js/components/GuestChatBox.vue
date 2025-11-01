<template>
    <div class="chat-container">
        <div class="chat-panel">

            <!-- Main Chat Area -->
            <div class="chat-main">
                <div class="chat-header">
                    <div class="chat-header-user">
                        <div class="chat-header-avatar">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=0D6EFD&color=fff" alt="User">
                        </div>
                        <div class="chat-header-info">
                            <h6>WELCOME TO OUT CHAT BOX</h6>
                            <span class="chat-header-status">
                                <i class="fas fa-circle"></i> Active now
                            </span>
                        </div>
                    </div>

                </div>

                <div class="chat-body"  ref="messagesContainer">


                    <!-- User Message -->
                    <!-- <div class="message user">
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=0D6EFD&color=fff" alt="User">
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-name">John Doe</span>
                                <span class="message-time"><i class="far fa-clock me-1"></i>10:30 AM</span>
                            </div>
                            <div class="message-bubble">
                                Hello! I need help with my account setup. Can you assist me?
                            </div>
                        </div>
                    </div> -->

                    <!-- Admin Message -->
                    <!-- <div class="message admin">
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-time"><i class="far fa-clock me-1"></i>10:31 AM</span>
                                <span class="message-name">Admin Support</span>
                            </div>
                            <div class="message-bubble">
                                Hello John! Of course, I'd be happy to help you with your account setup. What specific issue
                                are you facing?
                            </div>
                        </div>
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=Admin+Support&background=198754&color=fff"
                                alt="Admin">
                        </div>
                    </div> -->

                    <div v-for="(message, index) in messages" :key="index" class="message" :class="message.sender_type === 'guest' ? 'admin' : 'user'">
                        <!-- for Guest User Message -->
                        <div class="message-content" v-if="message.sender_type == 'guest'">
                            <div class="message-header">
                                <span class="message-time"><i class="far fa-clock me-1"></i>{{ formatTime(message.created_at) }}</span>
                                <span class="message-name">{{  'You' }}</span>
                            </div>
                            <div class="message-bubble">
                                {{ message.content }}
                            </div>
                        </div>
                        <div class="message-avatar" v-if="message.sender_type == 'guest'">
                            <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(message?.senderable?.name || 'Guest')}&background=198754&color=fff`"
                                alt="Guest">
                        </div>

                        <!-- for system and admin user message -->
                        <div class="message-avatar"  v-if="message.sender_type != 'guest'">
                            <img  v-if="message.senderable == null" :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(message?.senderable?.name || 'Admin')}&background=0D6EFD&color=fff`" alt="Admin">
                            <img  v-else  :src="message.senderable.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(message.senderable.first_name || 'System')}&background=198754&color=fff`"  alt="Admin">
                        </div>
                        <div class="message-content" v-if="message.sender_type != 'guest'">
                            <div class="message-header">
                                <span class="message-name">{{ message?.senderable?.first_name || 'Admin Support' }}</span>
                                <span class="message-time"><i class="far fa-clock me-1"></i>{{ formatTime(message.created_at) }}</span>
                            </div>
                            <div class="message-bubble">
                                {{ message.content }}
                            </div>
                        </div>
                    </div>



                    <!-- Typing Indicator -->
                    <!-- <div class="message user typing-indicator">
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=0D6EFD&color=fff"
                                alt="User">
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                <span class="typing-dot"></span>
                                <span class="typing-dot"></span>
                                <span class="typing-dot"></span>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="chat-footer" v-if="this.chat?.status == 'open'">
                    <div class="chat-input-wrapper">
                        <div class="input-group-custom">

                            <input type="text" placeholder="Type your message here..."
                            v-model="newMessage"
                             @keyup.enter="sendMessage"
                            >

                        </div>
                        <button class="send-button" @click="sendMessage" :disabled="isSending">
                            <i v-if="!isSending" class="fas fa-paper-plane"></i>
                            <i v-else class="fas fa-spinner fa-spin"></i>
                            <span>{{ isSending ? 'Sending...' : 'Send' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name:'GuestChatBox',
    props: ["chat"],
    data() {
        return {
            chat_id: this.chat?.id,
            messages: [],
            newMessage:'',
            isFriendTyping:false,
            isFriendTypingTimer:null,
            isUserOnline: false,
            isSending: false,
        };
    },
    watch: {
         messages: {
            handler() {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
            deep: true,
        },
    },
    mounted() {
        this.fetchMessages();
         this.listenForMessages();

        // Echo.channel(`chat.${this.chat_id}`)
        // .listen(".message.sent", (response) => {
        //     // this.messages.push(response.message);
        //     console.log("New message received via Echo:", response);

        // })
    },
    methods:{
        listenForMessages() {
            window.Echo.channel(`chat.${this.chat_id}`)
                .listen(".message.sent", (e) => {
                    console.log("New message received via Echo:", e);
                    let find = this.messages.find(msg => msg.id === e.id);
                    if(find) return;
                    this.messages.push(e);
                    // this.messages.push({
                    //     id: e.message.id,
                    //     chat_id: e.message.chat_id,
                    //     sender_type: e.message.sender_type,
                    //     content: e.message.content,
                    //     is_auto_reply: e.message.is_auto_reply,
                    //     created_at: e.message.created_at,
                    // });
                    this.scrollToBottom();
                });
                // .listen(".agent.typing", (e) => {
                // this.isAgentTyping = e.is_typing;
                // this.agentName = e.agent_name;

                // if (e.is_typing) {
                //     clearTimeout(this.typingTimeout);
                //     this.typingTimeout = setTimeout(() => {
                //     this.isAgentTyping = false;
                //     }, 3000);
                // }
                // });
            },
          scrollToBottom() {
            const messagesContainer = this.$refs.messagesContainer;
            if (messagesContainer) {
                messagesContainer.scrollTo({
                    top: messagesContainer.scrollHeight,
                    behavior: "smooth",
                });
            }
        },
        fetchMessages(){
            axios.get(`/chat/${this.chat_id}/messages`)
            .then(response => {
                this.messages = response.data.messages;
                this.scrollToBottom();
            })
            .catch(error => {
                console.error("Error fetching messages:", error);
            });
        },

        sendMessage(){
            if(this.newMessage.trim() === '' || this.isSending){
                return;
            }

            this.isSending = true;
            const messageData = {
                message: this.newMessage.trim(),
                guest_id: this.chat.guest_id
            };
            axios.post('/chat/send-message', messageData)
            .then(response => {
                this.newMessage = '';
                let find = this.messages.find(msg => msg.id === response?.data?.message.id);
                if(find) return;
                this.messages.push(response?.data?.message);

            })
            .catch(error => {
                console.error("Error sending message:", error);
            })
            .finally(() => {
                this.isSending = false;
            });
        },

        formatTime(timestamp) {
            if (!timestamp) return '';

            const date = new Date(timestamp);
            let hours = date.getHours();
            const minutes = date.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const minutesStr = minutes < 10 ? '0' + minutes : minutes;

            return `${hours}:${minutesStr} ${ampm}`;
        }
    }
};
</script>
<style scoped>
        .chat-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .chat-panel {

            grid-template-columns: 350px 1fr;
            gap: 20px;
            height: calc(100vh - 100px);
            min-height: 600px;
            width: 80%;
            margin: 0 auto;
        }

        /* Sidebar - Chat List */
        .chat-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .sidebar-header h5 {
            margin: 0 0 15px 0;
            font-weight: 600;
            color: #2c3e50;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .chat-list {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f8f9fa;
        }

        .chat-list::-webkit-scrollbar {
            width: 6px;
        }

        .chat-list::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .chat-list::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .chat-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f8f9fa;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-item:hover {
            background-color: #f8f9fa;
        }

        .chat-item.active {
            background-color: #e7f3ff;
            border-left: 3px solid #0d6efd;
        }

        .chat-item-avatar {
            position: relative;
            flex-shrink: 0;
        }

        .chat-item-avatar img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        .status-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .status-dot.online {
            background-color: #28a745;
        }

        .status-dot.offline {
            background-color: #6c757d;
        }

        .chat-item-content {
            flex: 1;
            min-width: 0;
        }

        .chat-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .chat-item-name {
            font-weight: 600;
            font-size: 14px;
            color: #2c3e50;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-item-time {
            font-size: 11px;
            color: #6c757d;
            white-space: nowrap;
        }

        .chat-item-message {
            font-size: 13px;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .unread-badge {
            background-color: #0d6efd;
            color: white;
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Main Chat Area */
        .chat-main {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chat-header-avatar img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .chat-header-info h6 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
        }

        .chat-header-status {
            font-size: 13px;
            color: #28a745;
        }

        .chat-header-status i {
            font-size: 8px;
        }

        .chat-header-actions button {
            border: none;
            background: none;
            color: #6c757d;
            font-size: 18px;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .chat-header-actions button:hover {
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        .chat-body {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f8f9fa;
            max-height: 350px;
        }

        .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .message {
            display: flex;
            margin-bottom: 20px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            justify-content: flex-start;
        }

        .message.admin {
            justify-content: flex-end;
        }

        .message-avatar img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .message-content {
            max-width: 60%;
            margin: 0 12px;
        }

        .message-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }

        .message.user .message-header {
            justify-content: flex-start;
        }

        .message.admin .message-header {
            justify-content: flex-end;
        }

        .message-name {
            font-weight: 600;
            font-size: 13px;
            color: #2c3e50;
        }

        .message-time {
            font-size: 11px;
            color: #6c757d;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .message.user .message-bubble {
            background-color: #f8f9fa;
            color: #2c3e50;
            border-bottom-left-radius: 4px;
        }

        .message.admin .message-bubble {
            background-color: #0d6efd;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .date-divider {
            text-align: center;
            margin: 25px 0;
        }

        .date-divider span {
            background-color: #e9ecef;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .typing-indicator .message-bubble {
            display: flex;
            gap: 4px;
            padding: 12px 16px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #6c757d;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
                opacity: 0.4;
            }

            30% {
                transform: translateY(-8px);
                opacity: 1;
            }
        }

        .chat-footer {
            padding: 20px 25px;
            border-top: 1px solid #e9ecef;
            background-color: white;
        }

        .chat-input-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .input-group-custom {
            flex: 1;
            display: flex;
            background-color: #f8f9fa;
            border-radius: 25px;
            padding: 5px 10px;
            align-items: center;
        }

        .input-group-custom button {
            border: none;
            background: none;
            color: #6c757d;
            padding: 8px 12px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .input-group-custom button:hover {
            color: #0d6efd;
        }

        .input-group-custom input {
            flex: 1;
            border: none;
            background: none;
            padding: 10px;
            font-size: 14px;
            outline: none;
        }

        .send-button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .send-button:hover:not(:disabled) {
            background-color: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .send-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .chat-panel {
                grid-template-columns: 1fr;
            }

            .chat-sidebar {
                display: none;
            }

            .message-content {
                max-width: 75%;
            }
        }

        @media (max-width: 576px) {
            .chat-container {
                margin: 10px auto;
            }

            .chat-panel {
                height: calc(100vh - 50px);
            }

            .message-content {
                max-width: 85%;
            }

            .chat-header {
                padding: 15px;
            }

            .chat-body {
                padding: 15px;
            }

            .send-button {
                padding: 12px 20px;
            }
        }
    </style>
