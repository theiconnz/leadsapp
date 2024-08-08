<script setup>
import {ref, watchEffect, reactive} from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useReCaptcha } from "vue-recaptcha-v3";
import { FwbToggle, FwbAlert, FwbSpinner, FwbTextarea, FwbProgress } from 'flowbite-vue'

const dataloading = ref(false);
const availableCountries = ref([]);
const referrals = ref([]);
const progress = ref(0);
const editmode = ref(false);
const messageDanger = ref('');
const messageSuccess = ref('');
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha()

const buttonText = ref('Submit');
const form = useForm({
    _method: 'PUT',
    firstname: '',
    lastname: '',
    email: '',
    phone: "",
    mobile:'',
    referral:'Other',
    termsaccepted:false,
    countrycode:'NZ',
    mode:0,
    errors: [],
    captcha_token :null,
});

const recaptcha = async () => {
    await recaptchaLoaded()
    form.captcha_token = await executeRecaptcha('login')
    //submit();
}


function addAction(event) {
    form.post(route('leads.save'), {
        errorBag: 'createLeads',
        preserveScroll: true,
        onSuccess: () => {
            console.log(response)
            progress.value=100;
            editmode.value=false;
            messageSuccess.value="Your data is saved";
            form.reset();
            setTimeout(() => {
                messageSuccess.value='';
                progress.value=0;
            }, "6000");
        },
        onError: (errors) => {
            form.errors = errors
            progress.value=0;
            editmode.value=false;
            messageDanger.value="Error while trying to save data.";
            setTimeout(() => {
                messageDanger.value='';
                progress.value=0;
            }, "6000");
        },
        onBefore: () => {
            editmode.value=true;
            progress.value=5;
        },
        onStart: () => {
            progress.value=20;
        },
        onProgress: () => {
            setTimeout(() => {
                if (progress<=80){
                    progress.value=+8;
                }
            }, "200");
        },
        onCancel: () => {
            progress.value=0;
            editmode.value=false;
        },
        onFinish: () => {
            progress.value=0;
            editmode.value=false;
        },
    });
}

function getFeedList(){
    dataloading.value=true
    axios.get('/getdata')
        .then(res => {
            availableCountries.value = res.data.data.countries
            referrals.value = res.data.data.referrals
        }).catch(err => {
        console.log(err)
    })
}

const clearForm = (event) => {
    form.reset();
}

watchEffect(async () => {
    if (!dataloading) {
        getFeedList();
    }
 });
getFeedList();
</script>

<template>
    <FormSection @submitted="addAction" @keydown.enter.prevent>
        <template #title>
            New Form
        </template>

        <template #form>
            <div class="col-span-12" >
                <InputError class="mt-2" :message="form.errors.message" />
            </div>

            <div class="col-span-12" >
                <InputLabel for="url" value="First name" />

                <div class="col-span-6" key="index">
                    <TextInput
                        id="firstname"
                        type="text"
                        v-model="form.firstname"
                        class="mt-1 block w-full"
                        autocomplete="fieldurl"
                        aria-placeholder="firstname"
                        aria-required="true"
                    />
                    <InputError class="mt-2" :message="form.errors.firstname" />
                </div>
            </div>

            <div class="col-span-12" >
                <InputLabel for="lastname" value="Last name" />

                <div class="col-span-6" key="index">
                    <TextInput
                        id="firstname"
                        type="text"
                        v-model="form.lastname"
                        class="mt-1 block w-full"
                        autocomplete="lastname"
                        aria-placeholder="lastname"
                    />
                    <InputError class="mt-2" :message="form.errors.lastname" />
                </div>
            </div>


            <div class="col-span-12" >
                <InputLabel for="email" value="Email" />

                <div class="col-span-6" key="index">
                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        class="mt-1 block w-full"
                        autocomplete="fieldurl"
                        aria-placeholder="Email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <div class="col-span-12" >
                <InputLabel for="mobile" value="Mobile" />

                <div class="col-span-6" key="index">
                    <TextInput
                        id="mobile"
                        type="text"
                        v-model="form.mobile"
                        class="mt-1 block w-full"
                        autocomplete="mobile"
                        aria-placeholder="mobile"
                        aria-valuemax="20"
                    />
                    <InputError class="mt-2" :message="form.errors.mobile" />
                </div>
            </div>

            <div class="col-span-12" >
                <InputLabel for="country" value="Country" />

                <div class="col-span-6" key="index">
                    <select v-model="form.countrycode" >
                        <option v-for="(country, index) in availableCountries" :key="index"
                                :value="index" class="flex">
                            {{country}}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.countrycode" />
                </div>
            </div>

            <div class="col-span-12" >
                <div class="col-span-6" key="index">
                    <FwbTextarea v-model="form.notes"
                                 :rows="4" aria-valuemax="200">

                    </FwbTextarea>
                    <InputError class="mt-2" :message="form.errors.notes" />
                </div>
            </div>

            <div class="col-span-12" >
                <div class="col-span-6" key="index">
                    <fwb-toggle v-model="form.termsaccepted" color="green"
                                label="I accept terms and conditions,"
                                aria-required="true" required />
                    <InputError class="mt-2" :message="form.errors.termsaccepted" />
                </div>
            </div>

        </template>

        <template #actions>
            <fwb-progress :progress="progress" v-if="editmode" size="sm" label="Small" />

            <fwb-spinner v-if="editmode" size="12" />

            <fwb-alert type="danger" v-if="!!messageDanger" icon>
                {{messageDanger}}
            </fwb-alert>
            <fwb-alert type="success" v-if="!!messageSuccess" icon>
                {{messageSuccess}}
            </fwb-alert>

            <SecondaryButton @click="clearForm" v-if="!editmode" class="m-3">
                clear
            </SecondaryButton>

            <PrimaryButton class="m-3" v-if="!editmode">
                {{buttonText}}
            </PrimaryButton>

        </template>
    </FormSection>
</template>
