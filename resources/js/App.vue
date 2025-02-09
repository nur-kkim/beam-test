<script setup lang="ts">
import CustomerForm from "./components/Customer.vue";
import DeviceForm from "./components/Device.vue";
import OrderForm from "./components/Order.vue";
import { onMounted, ref } from "vue";
import DeviceTable from "./components/DeviceTable.vue";
import ModalCustomer from "./components/ModalCustomer.vue";
import ModalOrder from "./components/ModalOrder.vue";
import ModalDevice from "./components/ModalDevice.vue";

const customer = ref([]);

const updateCustomer = (newCustomer: any) => {
  console.log(newCustomer);
  customer.value = newCustomer;
};
</script>

<template>
  <div class="container mx-auto p-4">
    <ModalCustomer @customerCreated="updateCustomer"/>
    <ModalOrder :addresses="customer.addresses"/>
    <ModalDevice/>
    <DeviceTable/>
  </div>
</template>

<style>
  .container {
    margin: 5rem auto;
    max-width: 1800px;
    display: flex;
    flex-direction: column;
  }
</style>