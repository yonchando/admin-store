<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Cards/Card.vue";
import Collapse from "@/Components/Collapses/Collapse.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <Card>
            <h2
                class="tw-mb-4 tw-text-xl tw-font-semibold tw-leading-tight tw-text-gray-800 dark:tw-text-gray-200"
            >
                Dashboard
            </h2>

            <div class="tw-text-gray-900 dark:tw-text-gray-100">
                You're logged in!
            </div>

            <div>
                <Collapse label="According">
                    <ul>
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                    </ul>
                </Collapse>
                <Collapse label="According">
                    <ul>
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                    </ul>
                </Collapse>
            </div>
        </Card>
    </AppLayout>
</template>
