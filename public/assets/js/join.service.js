document.addEventListener('alpine:init', function(){
    Alpine.data('joinService', function(){
        return {
            step: 1,
            stepWidth: 33.33,
            goToStep(val) {
                this.step = val;
                this.stepWidth = val == 3 ? 100 : val == 2 ? 66.67 : 33.33;
            },
            handleRegister(form){
                toast.error('Testing');
                
            },
        };
    });
});