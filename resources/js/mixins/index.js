export default {
    methods: {
        getStatusColor(status) {
            switch (status) {
                case 'pending':
                    return 'orange';
                case 'in_progress':
                    return 'blue';
                case 'completed':
                    return 'green';
                default:
                    return 'red';
            }
        },
    },
};
