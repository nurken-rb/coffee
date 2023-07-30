<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          Quasar App
        </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label header>
          Действия
        </q-item-label>
        <q-item>
          <q-item-section>
            <router-link :to="{name: 'index'}">Список</router-link>
            <router-link :to="{name: 'positionCreate'}">Добавить</router-link>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
import EssentialLink from 'components/EssentialLink.vue'
import IndexPage from "pages/IndexPage.vue";

const linksList = [

  {
    title: 'Список',
  },
]

export default defineComponent({
  name: 'MainLayout',

  components: {
    IndexPage,
    EssentialLink
  },

  setup () {
    const leftDrawerOpen = ref(false)

    return {
      essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer () {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
})
</script>

<style>
a {
  display: block;
  width: 125px;
  height: 30px;
  margin-top: 20px;
  text-align: center;
  text-decoration: none;
  background: #d2dfec;
  font-size: 16px;
  font-weight: bold;
  border-radius: 5px;
}
</style>
