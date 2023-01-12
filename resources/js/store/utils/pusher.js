export default {
    getMessage(channel, event, callback) {
        window.Echo.channel(channel).listen(event, callback);
    },
    privateMessage(channel, event, callback) {
        window.Echo.private(channel).listen(event, callback);
    },
};
