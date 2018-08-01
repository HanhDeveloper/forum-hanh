$(function () {
    new Vue({
        el: '#chatbox',
        data: {
            messages: []
        },
        created: function () {
            this.getMessages();
            this.ping();
        },
        methods: {
            getMessages: function () {
                axios.post(base + 'chat/messages').then((response) => {
                    console.log(response.data);
                    this.messages = response.data.result;
                });
            },
            getMessage: function () {
                setInterval(() => {
                    this.messages.push({message: 'hamh'});
                }, 5000);
            },
            ping: function () {
                setInterval(this.getMessages, 5000);
            }
        },
        computed: {
            listItems() {
                return _.orderBy(this.messages, 'id', 'desc');
            }
        }
    })
});
