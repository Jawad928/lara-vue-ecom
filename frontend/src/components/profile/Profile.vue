<script setup>
import { useAuthStore } from "../../stores/UseAuthStore";
import { Base_URL } from "../../helpers/config";
import ProfileSidebar from "./ProfileSidebar.vue";
import ProfileUserInfos from "./ProfileUserInfos.vue";

const authStore = useAuthStore();
</script>

<template>
  <div class="row my-5">
    <ProfileSidebar></ProfileSidebar>
    <ProfileUserInfos :updatingProfile="true"></ProfileUserInfos>
  </div>
</template>

<style scoped></style>
