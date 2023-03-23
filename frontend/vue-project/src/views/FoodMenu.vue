<template>
  <div class="weekly-menus p-5">
    <div v-for="(restaurant, index) in restaurants" :key="index" class="restaurant-menu">
      <h3>{{ restaurant.name }}</h3>
      <div class="menu">
        <div v-for="(menu, dayIndex) in restaurant.menu" :key="dayIndex" class="menu-day">
          <h5 class="">{{ days[dayIndex] }}</h5>
          <ul>
            <li v-for="(item, itemIndex) in menu" :key="itemIndex">{{ item }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "WeeklyMenus",
  data() {
    return {
      days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      restaurants: [
        {
          name: "Restaurant 1",
          menu: [
            ["Item 1.1", "Item 1.2", "Item 1.3"],
            ["Item 2.1", "Item 2.2", "Item 2.3"],
            ["Item 3.1", "Item 3.2", "Item 3.3"],
            //... more menu items for Restaurant 1
          ],
        },
        {
          name: "Restaurant 2",
          menu: [
            ["Item 1.1", "Item 1.2", "Item 1.3"],
            ["Item 2.1", "Item 2.2", "Item 2.3"],
            ["Item 3.1", "Item 3.2", "Item 3.3"],
            //... more menu items for Restaurant 2
          ],
        },
        {
          name: "Restaurant 3",
          menu: [
            ["Item 1.1", "Item 1.2", "Item 1.3"],
            ["Item 2.1", "Item 2.2", "Item 2.3"],
            ["Item 3.1", "Item 3.2", "Item 3.3"],
            //... more menu items for Restaurant 3
          ],
        },
      ],
    };
  },
};
</script>

<style scoped>
.weekly-menus {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.restaurant-menu {
  flex-basis: calc(33% - 20px);
  margin-bottom: 20px;
  /*background-color: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 4px;*/
  padding: 10px;
  text-align: center;
}

.menu {
 
  flex-wrap: wrap;
  justify-content: space-between;
}

.menu-day {
  flex-basis: calc(33% - 10px);
  margin-bottom: 10px;
  text-align: left;
}


@media (max-width: 768px) {
  .restaurant-menu {
    flex-basis: 100%;
    margin-bottom: 20px;
  }
}
</style>
