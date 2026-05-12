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

            packages: [],
            newPackage: null,
            packageOpen: false,
            packageActionOpen: false,

            timetableFile: null,
            timetableLink: '',

            qualifications: [],
            newQualification: {
                id: 1, open: false, name: '', file: null, consent: false,
            },

            teams: [],
            timings: [
                {
                    key: 1, title: 'Monday', enabled: true, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'06', mm:'00' }, end: { hh:'22', mm:'00' } }],
                }, {
                    key: 2, title: 'Tuesday', enabled: true, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'06', mm:'00' }, end: { hh:'22', mm:'00' } }],
                }, {
                    key: 3, title: 'Wednesday', enabled: true, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'06', mm:'00' }, end: { hh:'22', mm:'00' } }],
                }, {
                    key: 4, title: 'Thursday', enabled: true, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'06', mm:'00' }, end: { hh:'22', mm:'00' } }],
                }, {
                    key: 5, title: 'Friday', enabled: true, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'06', mm:'00' }, end: { hh:'22', mm:'00' } }],
                }, {
                    key: 6, title: 'Saturday', enabled: false, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'', mm:'' }, end: { hh:'', mm:'' } }],
                }, {
                    key: 0, title: 'Sunday', enabled: false, is24Hours: false,
                    hours: [{ id: 1, start: { hh:'', mm:'' }, end: { hh:'', mm:'' } }],
                },
            ],

            addTimingsHour(val) {
                if (val.hours.length >= 10) {
                    toast.error('Max 10 allowed');
                    return;
                }
                val.hours.push({ id: Date.now(), start: { hh:'', mm:'' }, end: { hh:'', mm:'' } });
            },
            removeTimingsHour(val, hour) {
                var index = val.hours.findIndex(function(itemObj) {
                    return itemObj.id === hour.id;
                });
                val.hours.splice(index, 1);
            },

            addQualification() {
                if (self.qualifications.length >= 10) {
                    toast.error('Max 10 allowed');
                    return;
                }
                if (!self.newQualification.name.trim().length) {
                    toast.error('Name is required');
                    return;
                }
                if (!self.newQualification.file) {
                    toast.error('Please add image or pdf file');
                    return;
                }
                if (!self.newQualification.consent) {
                    toast.error('Please accept consent');
                    return;
                }
                self.qualifications.push({
                    id: Date.now(),
                    status: 'pending',
                    name: self.newQualification.name,
                    file: self.newQualification.file,
                });
                self.newQualification.name = '';
                self.newQualification.file = null;
                self.newQualification.open = false;
                self.newQualification.consent = false;
                self.checkStep('qualifications');
            },
            removeQualification(val) {
                var index = self.qualifications.findIndex(function(itemObj) {
                    return itemObj.id === val.id;
                });
                if (index !== -1) {
                    self.qualifications.splice(index, 1);
                }
                self.checkStep('qualifications');
            },
            handleQualificationFile(e) {
                if (e.target.files.length) {
                    var file = e.target.files[0];
                    self.newQualification.file = file;
                    e.target.value = '';
                }
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
                formData.append('packages', JSON.stringify(self.packages));
                formData.append('conversion', JSON.stringify(self.conversion));

                if (self.timetableFile?.file) {
                    formData.append('timetable', self.timetableFile.file);
                } else if (self.timetableFile?.remove) {
                    formData.append('remove_timetable', '1');
                }

                formData.append('timings', JSON.stringify(self.timings));

                var teams = self.teams.map(function(team, index) {
                    if (team.file) {
                        formData.append('team_files[' + index + ']', team.file);
                    }
                    return {
                        id: team.id,
                        job: team.job,
                        name: team.name,
                        has_file: !!team.file,
                        listing_id: team.listing_id,
                    };
                });
                formData.append('teams', JSON.stringify(teams));

                var qualifications = self.qualifications.map(function(item, index) {
                    if (item.file && typeof item.file !== 'string') {
                        formData.append('qualification_files[' + index + ']', item.file);
                    }
                    return {
                        id: item.id,
                        name: item.name,
                        has_file: !!item.file,
                        status: item.status == 'pending' ? item.status : null,
                    };
                });
                formData.append('qualifications', JSON.stringify(qualifications));

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
                    if (res.data.teams?.length) {
                        self.teams = res.data.teams;
                    }
                    if (res.data.qualifications?.length) {
                        self.qualifications = res.data.qualifications;
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
                    if (res.data.teams) {
                        self.teams = res.data.teams;
                    }
                    if (res.data.qualifications) {
                        self.qualifications = res.data.qualifications;
                    }
                    if (res.data.item.perks) {
                        self.perks = res.data.item.perks;
                    }
                    if (res.data.item.timings) {
                        self.timings = res.data.item.timings;
                    }
                    if (res.data.item.conversion) {
                        self.conversion = res.data.item.conversion;
                    }
                    if (res.data.item.packages) {
                        self.packages = res.data.item.packages;
                    }
                    if (res.data.item.timetable?.length) {
                        self.timetableFile = {
                            name: self.cleanFilename(res.data.item.timetable),
                            url: res.data.item.timetable_url,
                        };
                    }
                    self.checkStep('hours');
                    self.checkStep('teams');
                    self.checkStep('media');
                    self.checkStep('about');
                    self.checkStep('packages');
                    self.checkStep('location');
                    self.checkStep('timetable');
                    self.checkStep('conversion');
                    self.checkStep('qualifications');
                    self.checkStep('contact-and-socials');
                }).catch(function(err) {
                    console.log(getErrorMessage(err), err);
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
            handleTimetableFile(e) {
                if (e.target.files.length) {
                    var file = e.target.files[0];
                    if (file.size > 5242880) {
                        toast.error('File too large: ' + file.name);
                        e.target.value = '';
                        return;
                    }
                    self.timetableFile = {
                        name: file.name,
                        file: file,
                    };
                    e.target.value = '';
                    self.checkStep('timetable');
                }
            },
            removeTimetableFile() {
                self.timetableFile = {
                    name: '',
                    remove: true,
                }
                self.checkStep('timetable');
            },
            downloadTimetableFile() {
                if (self.timetableFile.url.length) {
                    var a = document.createElement('a');
                    a.setAttribute('target', '_blank');
                    a.setAttribute('download', self.timetableFile.name);
                    a.setAttribute('href', self.timetableFile.url);
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }
            },

            addTeam() {
                if (self.teams.length >= 10) {
                    toast.error('Max 10 team members allowed');
                    return;
                }
                self.teams.push({
                    id: Date.now(),
                    job: '',
                    name: '',
                    keyword: '',
                    suggestions: [],
                    listing_id: null,
                });
                self.checkStep('teams');
            },
            removeTeam(val) {
                var index = self.teams.findIndex(function(fileObj) {
                    return fileObj.id === val.id;
                });
                if (index !== -1) {
                    self.teams.splice(index, 1);
                }
            },
            handleTeamFile(e, team) {
                if (e.target.files.length) {
                    var file = e.target.files[0];
                    team.file = file; // the File object
                    team.file_url = URL.createObjectURL(file);
                    e.target.value = '';
                }
            },
            handleTeamKeyword(team) {
                team.open = true;
                team.loading = true;
                axios.get('', {
                    params: {ajax: 1, q: team.keyword, action: 'teams'}
                }).then(function(res) {
                    team.suggestions = res.data.items;
                }).catch(function(err) {
                    toast.error(getErrorMessage(err));
                }).finally(function() {
                    team.loading = false;
                });
            },
            handleTeamSuggestion(val, team) {
                team.listing = val;
                team.open = false;
            },
            removeTeamSuggestion(team) {
                team.keyword = '';
                team.listing = null;
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

            openPackage() {
                self.packageOpen = true;
                self.newPackage = {
                    id: Date.now(),
                    title: '',
                    price: '',
                    action: {type: 'website', value: '', prefix: '44'},
                    benefits: [{id: Date.now(), title: ''}],
                };
            },
            addPackageBenefit() {
                if (self.newPackage.benefits.length >= 5) {
                    toast.show('Max 5 allowed');
                    return;
                }
                self.newPackage.benefits.push({
                    id: Date.now(), title: '',
                });
            },
            removePackageBenefit(val) {
                var index = self.newPackage.benefits.findIndex(function(itemObj) {
                    return itemObj.id === val.id;
                });
                if (index !== -1) {
                    self.newPackage.benefits.splice(index, 1);
                }
            },
            savePackage() {
                if (!self.newPackage.title.length) {
                    toast.error('Enter title of Package');
                    return;
                }
                if (!self.newPackage.action.value.length) {
                    toast.error('Add a call to action in Package');
                    return;
                }
                if (['email'].includes(self.newPackage.action.type) && !self.isValidEmail(self.newPackage.action.value)) {
                    toast.error('Enter valid email');
                    return;
                }
                if (['website', 'form', 'custom'].includes(self.newPackage.action.type) && !self.isValidUrl(self.newPackage.action.value)) {
                    toast.error('Enter valid url');
                    return;
                }
                self.packages.push(self.newPackage);
                self.closePackage();
                setTimeout(function(){
                    var packagesSection = document.getElementById('item-packages');
                    if (packagesSection) {
                        packagesSectionPosition = packagesSection.getBoundingClientRect().top;
                        window.scrollTo({ top: packagesSectionPosition + window.pageYOffset - 100, behavior: 'smooth'});
                    }
                }, 100);
            },
            removePackage(val) {
                var index = self.packages.findIndex(function(itemObj) {
                    return itemObj.id === val.id;
                });
                if (index !== -1) {
                    self.packages.splice(index, 1);
                }
                self.checkStep('packages');
            },
            closePackage() {
                self.packageOpen = false;
                self.checkStep('packages');
            },
            openPackageAction() {
                self.packageActionOpen = true;
                self.checkStep('packages');
            },
            closePackageAction() {
                self.packageActionOpen = false;
            },
            handlePackageActionType(val) {
                self.closePackageAction();
                self.newPackage.action.value = '';
                self.newPackage.action.type = val.value;
            },


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
                } else if (val === 'packages') {
                    if (!!self.packages?.length) {
                        self.completedSteps.push('packages');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'packages';
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
                } else if (val === 'timetable') {
                    if (self.timetableLink?.length || self.timetableFile?.name?.length) {
                        self.completedSteps.push('timetable');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'timetable';
                        });
                    }
                } else if (val === 'teams') {
                    if (!!self.teams.length) {
                        self.completedSteps.push('teams');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'teams';
                        });
                    }
                } else if (val === 'hours') {
                    var hasEnabledDay = self.timings.some(function(day) {
                        return day.enabled;
                    });
                    if (hasEnabledDay) {
                        self.completedSteps.push('hours');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'hours';
                        });
                    }
                } else if (val === 'qualifications') {
                    if (self.qualifications.length > 0) {
                        self.completedSteps.push('qualifications');
                    } else {
                        self.completedSteps = self.completedSteps.filter(function(step) {
                            return step !== 'qualifications';
                        });
                    }
                }
            },

            cleanFilename(filename) {
                // remove everything up to and including "-timetable-"
                // Then remove ULID (26 chars) right before the extension
                return filename
                    .replace(/^.*-timetable-/, '')           // remove start through "-timetable-"
                    .replace(/-[0-9A-HJKMNP-TV-Z]{26}(?=\.[^.]+$)/, ''); // remove -ULID before ext
            },
            isValidEmail(value) {
                try {
                    return String(value)
                        .toLowerCase()
                        .match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
                } catch (_) {
                    return false;
                }
            },
            isValidUrl(value) {
                try {
                    var url = new URL(value);
                    return ['http:', 'https:'].includes(url.protocol);
                } catch (_) {
                    return false;
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