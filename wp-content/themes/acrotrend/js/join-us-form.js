



new Vue({
    el: '#contact_form',
    data: {
        name: '',
        email:'',
        message:'',
        maxLength: 140
    },
    methods: { // all the actions our app can do
        isValidName: function () { // TODO what if name is just spaces?
            var valid = this.name.length > 0;
            console.log('checking for a valid name: ' + valid);
            return valid;
        },
        isValidEmail: function () { // TODO is a@b a valid email?
            var valid = this.email.indexOf('@') > 0;
            console.log('checking for a valid email: ' + valid);
            return valid;
        },
        isValidMessage: function () { // what is message is just spaces?
            var valid = (this.message.length > 0) &&
                (this.message.length < this.maxLength);
            console.log('checking for a valid message: ' + valid);
            return valid;
        },
        checkMessage: function () {
        },
        submitForm: function () {
            // TODO prevent form from submitting if name, email, or message
            //      are invalid and display message
            // TODO submit to form processor
            console.log('submitting message...');
            this.$http({url: '/someUrl', method: 'POST', data: {
                name: this.name,
                email: this.email,
                message: this.message
            }}).then(function () {
                alert('Your form was submitted!');
            }, function () {
                alert('Form submission failed');
            });
        }
    }
});