export default {
    getMessage(channel, event, callback) {
        window.Echo.channel(channel).listen(event, callback);
    },
};
