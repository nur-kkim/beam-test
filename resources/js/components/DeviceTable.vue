<template>
  <div class="container">
    <h1 class="title">Список заказов</h1>
    <table class="orders-table">
      <thead>
      <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Адрес</th>
        <th>Время доставки</th>
        <th>Имя получателя</th>
        <th>Действие</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="order in orders" :key="order.id">
        <td>{{ order.id }}</td>
        <td>{{ order.device.name }}</td>
        <td>{{ order.address.street }}</td>
        <td>{{ order.delivery_time }}</td>
        <td>{{ order.address.customer.name }}</td>
        <td style="color: red" @click="deleteOrder(order.id)">Удалить</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";

const orders = ref<Array<{
  id: number;
  address: string;
  delivery_time: string;
  device: string }>>
([]);

const getOrders = async () => {
  const response = await fetch("/api/orders");
  orders.value = await response.json();
};

const deleteOrder = async (id: number) => {
  const response = await fetch(`/api/orders/${id}`, {
    method: "DELETE",
  });

  if (response.ok) {
    orders.value = orders.value.filter((order) => order.id !== id);
  }
  getOrders();
};

onMounted(() => {
  getOrders();
});
</script>

<style scoped>
.container {
  width: 80%;
  margin: 0 auto;
  padding: 20px;
}

.title {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 20px;
}

.orders-table {
  width: 100%;
  border-collapse: collapse;
}

.orders-table th, .orders-table td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ddd;
}

.orders-table th {
  background-color: #f4f4f4;
}

.orders-table tr:nth-child(even) {
  background-color: #f9f9f9;
}
</style>
