$(function () {
    Vue.http.options.emulateJSON = true; // support send json
    new Vue({
        el: '#chatbox',
        data: {
            messages: [],
            txt: '',
            ajaxRequest: false,
        },
        created: function () {
            this.getMessages();
            this.ping();
        },
        methods: {
            getMessages: function () {
                this.$http.post(base + 'chat/messages').then((response) => {
                    console.log(response.data);
                    this.messages = response.data.result;
                });
            },
            send: function (txt) {
                this.ajaxRequest = true;
                setTimeout(this.$http.post(base + 'chat/save', {msg: txt}).then((response) => {
                    console.log(response);
                    this.getMessages();
                    this.ajaxRequest = false;
                }), 50000);
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
