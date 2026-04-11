document.addEventListener('alpine:init', function(){
   Alpine.data('prologue', function(){
       return {
           step: 1,
           type: '',
           service: '',
           starting: false,
           onTypeChange(val) {
               this.type = val;
           },
           onServiceChange(val) {
               this.service = val;
           },
           goBack() {
               this.step = 1;
               this.service = '';
           },
           goNext() {
               if (this.type === '') {
                   toast.error('Choose your business type');
                   return;
               }
               if (this.step == 1) {
                   this.step = 2;
                   return;
               }
               if (this.service === '') {
                   toast.error('Choose your business category');
                   return;
               }
               this.starting = true;
               toast.success('Loading...');
               window.location.href = '/join/' + this.service;
           },
       };
   });
});