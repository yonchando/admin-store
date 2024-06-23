<script setup>

import TextInput from "@/Components/Forms/TextInput.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import Card from "@/Components/Cards/Card.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import InfoButton from "@/Components/Buttons/InfoButton.vue";

function addGroup() {
    form.product_options.push({
        product_option_group_id: null,
        options: [
            {
                product_option_id: null,
                price_adjustment: null,
            },
        ],
    });
}
</script>

<template>
    <Card v-if="!product" collapse :title="lang.product_option">
        <template v-for="(group, i) in form.product_options">
            <Card>
                <div class="form-group row">
                    <div class="col-6">
                        <InputLabel :value="lang.option_group"/>
                        <SelectInput
                            v-model="group.product_option_group_id"
                            text="name"
                            :items="groups"
                        />
                    </div>
                </div>
                <div class="form-group tw-grid tw-grid-cols-2 tw-gap-4">
                    <template v-for="option in group.options">
                        <div class="">
                            <InputLabel :value="lang.options"/>
                            <SelectInput
                                v-model="option.product_option_id"
                                text="name"
                                :items="options"
                            />
                        </div>
                        <div class="">
                            <InputLabel
                                :value="lang.price_adjustment"
                            />
                            <TextInput
                                v-model="option.price_adjustment"
                                type="number"
                            />
                        </div>
                    </template>
                </div>
                <InfoButton
                    @click="
                                group.options.push({
                                    product_option_id: null,
                                    price_adjustment: null,
                                })
                            "
                >
                    {{ lang.add_option }}
                </InfoButton>
            </Card>
        </template>

        <InfoButton @click="addGroup">
            {{ lang.add_group }}
        </InfoButton>
    </Card>
</template>

<style scoped>

</style>