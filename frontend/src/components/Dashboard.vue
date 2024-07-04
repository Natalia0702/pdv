<template>
  <div class="hello">
    <h2>Bem Vindo ao PDV</h2>
    <div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link" :class="{ 'active': activeTab === 'inserir' }" @click="activeTab = 'inserir'" aria-controls="home-tab-pane">Inserir Produtos</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" :class="{ 'active': activeTab === 'lista' }" @click="activeTab = 'lista'" aria-controls="profile-tab-pane">Lista de Produtos</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" :class="{ 'active': activeTab === 'venda' }" @click="activeTab = 'venda'" aria-controls="profile-tab-pane">Venda de Produtos</button>
        </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div v-if="activeTab === 'inserir'" class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" tabindex="0"><ProdutosVue /></div>
          <div v-if="activeTab === 'lista'" class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" tabindex="0"><ListarProdutosVue /></div>
          <div v-if="activeTab === 'venda'" class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" tabindex="0"><VendasVue/></div>
        </div>
    </div>
  </div>
</template>

<script>
import ListarProdutosVue from './ListaProdutos.vue';
import ProdutosVue from './Produtos.vue';
import VendasVue from './Vendas.vue';

export default {
  name: 'DashBoard',
  components: {
    ListarProdutosVue,
    ProdutosVue,
    VendasVue
  },
  data() {
    return {
      activeTab: 'inserir'
    };
  }
}
</script>

<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>