document.addEventListener('alpine:init', function(){
    var self = null;
    var formId = 'item-update-form';

    var sessionToken = null;
    var autocompleteService = null;

    window.addEventListener('google-maps-loaded', function () {
        google.maps.importLibrary('places').then(function (places) {
            autocompleteService = places.AutocompleteSuggestion;
            sessionToken = new google.maps.places.AutocompleteSessionToken();
        });
    });


    Alpine.data('listing', function() {
        return {
            item: null,
            updateUrl: '',
            updating: false,
            mediaFiles: [],
            transformationFiles: [],
            message: '',
            messages: [],
            completedSteps: [],

            mediaFileDeletes: [],
            transformationFileDeletes: [],

            placeId: '',
            placeName: '',
            placeKeyword: '',
            placeSuggestions: [],

            mentions: [],
            mentionKeyword: '',
            mentionSuggestions: [],

            conversion: {
                enabled: false,
                type: '',
                label: '',
                prefix: '44',
                title: '', // custom btn title
                value: '', // custom btn url
            },
            conversionTypes: [],
            conversionTypesOpen: false,
            conversionLabelsOpen: false,

            perks: [],
            newPerk: null,
            perkOpen: false,
            perkActionOpen: false,

            openPerk() {
                self.perkOpen = true;
                self.newPerk = {
                    id: Date.now(),
                    title: '',
                    action: {type: 'website', value: '', prefix: '44'},
                    benefits: [{id: Date.now(), title: ''}],
                    steps: [{id: Date.now(), title: ''}],
                };
            },
            addPerkBenefit() {
                if (self.newPerk.benefits.length >= 5) {
                    toast.show('Max 5 allowed');
                    return;
                }
                self.newPerk.benefits.push({
                    id: Date.now(), title: '',
                });
            },
            removePerkBenefit(val) {
                var index = self.newPerk.benefits.findIndex(function(itemObj) {
                    return itemObj.id === val.id;
                });
                if (index !== -1) {
                    self.newPerk.benefits.splice(index, 1);
                }
            },
            addPerkStep() {
                if (self.newPerk.steps.length >= 5) {
                    toast.show('Max 5 allowed');
                    return;
                }
                self.newPerk.steps.push({
                    id: Date.now(), title: '',
                });
            },
            removePerkStep(val) {
                var index = self.newPerk.steps.findIndex(function(itemObj) {
                    return itemObj.id === val.id;
                });
                if (index !== -1) {
                    self.newPerk.steps.splice(index, 1);
                }
            },
            savePerk() {
                if (!self.newPerk.title.length) {
                    toast.error('Enter title of Perk');
                    return;
                }
                if (!self.newPerk.action.value.length) {
                    toast.error('How will they redeem Perk?');
                    return;
                }
                self.perks.push(self.newPerk);
                self.closePerk();
                setTimeout(function(){
                    var perksSection = document.getElementById('item-perks');
                    if (perksSection) {
                        perksSectionPosition = perksSection.getBoundingClientRect().top;
                        window.scrollTo({ top: perksSectionPosition + window.pageYOffset - 100, behavior: 'smooth'});
                    }
                }, 100);
            },
            removePerk(val) {
                var index = self.perks.findIndex(function(perkObj) {
                    return perkObj.id === val.id;
                });
                if (index !== -1) {
                    self.perks.splice(index, 1);
                }
            },
            closePerk() {
                self.perkOpen = false;
            },
            openPerkAction() {
                self.perkActionOpen = true;
            },
            closePerkAction() {
                self.perkActionOpen = false;
            },
            handlePerkActionType(val) {
                self.closePerkAction();
                self.newPerk.action.value = '';
                self.newPerk.action.type = val.value;
            },

            handleSubmit() {
                var form = document.getElementById(formId);
                var formData = new FormData(form);
                for (var i = 0; i < self.mediaFiles.length; i++) {
                    if (self.mediaFiles[i].local && self.mediaFiles[i].file) {
                        formData.append('media_file[]', self.mediaFiles[i].file);
                    }
                }
                for (var j = 0; j < self.transformationFiles.length; j++) {
                    if (self.transformationFiles[j].local && self.transformationFiles[j].file) {
                        formData.append('transformation_file[]', self.transformationFiles[j].file);
                    }
                }
                formData.append('media_file_deletes', JSON.stringify(self.mediaFileDeletes));
                formData.append('transformation_file_deletes', JSON.stringify(self.transformationFileDeletes));

                formData.append('place_id', self.placeId);
                formData.append('place_name', self.placeName);
                for (var k = 0; k < self.mentions.length; k++) {
                    formData.append('mention_id[]', self.mentions[k].id);
                }
                formData.append('perks', JSON.stringify(self.perks));
                formData.append('conversion', JSON.stringify(self.conversion));

                self.updating = true;
                self.messages = [];
                self.message = 'Please wait...';
                axios.post(self.updateUrl, formData, {
                    onUploadProgress: function (ev) {
                        if (ev.total > 2900 && ev.loaded) {
                            self.message = 'Uploading ' + toNiceBytes(ev.loaded) + ' of ' + toNiceBytes(ev.total);
                        }
                    },
                }).then(function(res) {
                    var msg = res.data.message;
                    self.message = msg;
                    toast.success(msg);
                    self.mediaFiles.forEach(function(item) {
                        if (item.local) {
                            item.local = false;
                            delete item.file;
                        }
                    });
                    self.transformationFiles.forEach(function(item) {
                        if (item.local) {
                            item.local = false;
                            delete item.file;
                        }
                    });
                    var fileInputs = form.querySelectorAll('input[type="file"]');
                    for (let j = 0; j < fileInputs.length; j++) {
                        fileInputs[j].value = '';
                    }
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    self.message = msg;
                    toast.error(msg);
                }).finally(function(){
                    self.updating = false;
                });
            },
            getItem() {
                axios.get('', { params: {ajax: 1} }).then(function(res) {
                    self.item = res.data.item;
                    self.mediaFiles = res.data.item.media_files;
                    self.conversionTypes = res.data.conversion_types;
                    self.transformationFiles = res.data.item.transformation_files;
                    self.completedSteps = res.data.completed_steps;
                    self.mentions = res.data.mentions;
                    self.placeId = res.data.item.place_id;
                    self.placeName = res.data.item.place_name;
                    if (res.data.item.perks) {
                        self.perks = res.data.item.perks;
                    }
                    if (res.data.item.conversion) {
                        self.conversion = res.data.item.conversion;
                    }
                    self.checkStep('media');
                    self.checkStep('about');
                    self.checkStep('location');
                    self.checkStep('conversion');
                    self.checkStep('contact-and-socials');
                }).catch(function(err) {
                });
            },
            isDuplicateFile(newFile, allFiles) {
                return allFiles.some(function(existing) {
                    return existing.name === newFile.name && existing.size === newFile.size;
                });
            },
            handleMediaFiles(e) {
                if (e.target.files.length) {
                    var files = e.target.files;
                    for (var i = 0; i < files.length; i++) {
                        var newFile = files[i];
                        // skip if > 5MB (5*1024*1024 bytes)
                        if (newFile.size > 5242880) {
                            toast.error('File too large: ' + newFile.name);
                            continue;
                        }
                        // check duplicate: same name AND size
                        if (!self.isDuplicateFile(newFile, self.mediaFiles)) {
                            self.mediaFiles.push({
                                id: Date.now() + i,
                                name: newFile.name,
                                size: newFile.size,
                                file: newFile,
                                local: true,
                            });
                        }
                    }
                    e.target.value = ''; // reset file input
                }
                self.checkStep('media');
            },
            handleTransformationFiles(e) {
                if (e.target.files.length) {
                    var files = e.target.files;
                    for (var i = 0; i < files.length; i++) {
                        var newFile = files[i];
                        // skip if > 5MB (5*1024*1024 bytes)
                        if (newFile.size > 5242880) {
                            toast.error('File too large: ' + newFile.name);
                            continue;
                        }
                        // check duplicate: same name AND size
                        if (!self.isDuplicateFile(newFile, self.transformationFiles)) {
                            self.transformationFiles.push({
                                id: Date.now() + i,
                                name: newFile.name,
                                size: newFile.size,
                                file: newFile,
                                local: true,
                            });
                        }
                    }
                    e.target.value = ''; // reset file input
                }
                self.checkStep('media');
            },
            removeMediaFile(val) {
                var index = self.mediaFiles.findIndex(function(fileObj) {
                    return fileObj.id === val.id;
                });
                if (index !== -1) {
                    self.mediaFiles.splice(index, 1);
                }
                if (!val.local) {
                    self.mediaFileDeletes.push(val.id);
                }
                self.checkStep('media');
            },
            removeTransformationFile(val) {
                var index = self.transformationFiles.findIndex(function(fileObj) {
                    return fileObj.id === val.id;
                });
                if (index !== -1) {
                    self.transformationFiles.splice(index, 1);
                }
                if (!val.local) {
                    self.transformationFileDeletes.push(val.id);
                }
                self.checkStep('media');
            },
            getFileUrl(val) {
                try {
                    if (val.local) {
                        return URL.createObjectURL(val.file);
                    } else {
                        return '/uploads/' + self.item.folder + '/' + val.name;
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            handlePlaceChange() {
                if (self.placeKeyword.length < 2) {
                    self.placeSuggestions = [];
                    return;
                }
                autocompleteService?.fetchAutocompleteSuggestions({
                    input: self.placeKeyword,
                    sessionToken: sessionToken,
                    includedRegionCodes: ['gb'],
                }).then(function (response) {
                    const suggestions = response.suggestions;
                    self.placeSuggestions = [];
                    if (suggestions && suggestions.length > 0) {
                        suggestions.forEach(function (suggestion) {
                            var mainText = `${suggestion.placePrediction.mainText.text}, ${suggestion.placePrediction.secondaryText?.text}`;
                            var placeId = suggestion.placePrediction.placeId;
                            self.placeSuggestions.push({ id: placeId, name: mainText });
                        });
                    }
                }).catch(function (err) {
                    console.error(err);
                    self.placeSuggestions = [];
                    toast.error('Error fetching autocomplete suggestions');
                });
            },
            handlePlaceSuggestionClick(val) {
                self.placeId = val.id;
                self.placeKeyword = '';
                self.placeName = val.name;
                self.placeSuggestions = [];
                self.checkStep('location');
            },
            removePlace() {
                self.placeId = '';
                self.placeName = '';
            },
            handleMentionChange(){
                axios.get('', {
                    params: {ajax: 1, action: 'mentions', q: self.mentionKeyword},
                }).then(function(res) {
                    console.log(res.data);
                    self.mentionSuggestions = res.data.items;
                }).catch(function(err) {
                    toast.error(getErrorMessage(err));
                });
            },
            removeMention(val) {
                self.mentions = [];
            },
            handleMentionSuggestionClick(val) {
                self.mentions = [];
                self.mentions.push(val);
                self.mentionKeyword = '';
                self.mentionSuggestions = [];
            },
            conversionTitleFor(value) {
                for (var i = 0; i < self.conversionTypes.length; i++) {
                    if (value === self.conversionTypes[i].value) {
                        return self.conversionTypes[i].title;
                    }
                }
                return 'Select Type';
            },
            conversionLabelFor(value) {
                for (var i = 0; i < self.conversionTypes.length; i++) {
                    if (self.conversion.type === self.conversionTypes[i].value) {
                        for (var j = 0; j < self.conversionTypes[i].labels.length; j++) {
                            if (value === self.conversionTypes[i].labels[j].value) {
                                return self.conversionTypes[i].labels[j].title;
                            }
                        }
                    }
                }
                return 'Select Button Text';
            },
            getConversionLabels() {
                for (var i = 0; i < self.conversionTypes.length; i++) {
                    if (self.conversion.type === self.conversionTypes[i].value) {
                        return self.conversionTypes[i].labels;
                    }
                }
                return [];
            },
            conversionPlaceholderFor(type) {
                return this.conversionTypes[type]?.placeholder || '';
            },
            openConversionTypes() {
                self.conversionTypesOpen = true;
            },
            closeConversionTypes() {
                self.conversionTypesOpen = false;
            },
            handleConversionType(val) {
                self.closeConversionTypes();
                self.conversion.title = '';
                self.conversion.label = '';
                self.conversion.value = '';
                self.conversion.type = val.value;
            },
            openConversionLabels() {
                self.conversionLabelsOpen = true;
            },
            closeConversionLabels() {
                self.conversionLabelsOpen = false;
            },
            handleConversionLabel(val) {
                self.closeConversionLabels();
                if (val.value === 'custom') {
                    self.conversion.title = '';
                } else {
                    self.conversion.title = val.title;
                }
                self.conversion.label = val.value;
                self.checkStep('conversion');
            },
            checkSteps() {
                // profile-and-cover-photo
                if (!self.completedSteps.includes('profile-and-cover-photo')) {
                    var itemProfileImage = document.getElementById('item-profile_image');
                    var itemCoverImage = document.getElementById('item-cover_image');
                    if (!!itemProfileImage.value && !!itemCoverImage.value) {
                        self.completedSteps.push('profile-and-cover-photo');
                    }
                }
            },
            checkStep(val) {
                if (val === 'tagging-permissions') {
                    if (!self.completedSteps.includes('tagging-permissions')) {
                        self.completedSteps.push('tagging-permissions');
                    }
                } else if (val === 'media') {
                    if (self.mediaFiles.length && self.transformationFiles.length) {
                        self.completedSteps.push('media');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'media';
                        });
                    }
                } else if (val === 'contact-and-socials') {
                    var section = document.getElementById('collapse-contact-and-socials');
                    var inputs = section.querySelectorAll('input[name$="[value]"]');
                    var hasAnyValue = false;
                    for (var i = 0; i < inputs.length; i++) {
                        if (inputs[i].value.trim() !== '') {
                            hasAnyValue = true;
                            break;
                        }
                    }
                    if (hasAnyValue) {
                        self.completedSteps.push('contact-and-socials');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'contact-and-socials';
                        });
                    }
                } else if (val === 'location') {
                    if (self.placeName.length > 0) {
                        self.completedSteps.push('location');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'location';
                        });
                    }
                } else if (val === 'conversion') {
                    if (!!self.conversion.value.length) {
                        self.completedSteps.push('conversion');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'conversion';
                        });
                    }
                } else if (val === 'about') {
                    var itemAbout = document.getElementById('item-about');
                    if (!!itemAbout?.value.trim().length) {
                        self.completedSteps.push('about');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'about';
                        });
                    }
                }
            },
            init() {
                self = this;
                var form = document.getElementById(formId);
                self.updateUrl = form.getAttribute('action');
                self.getItem();
            }
        };
    });
});