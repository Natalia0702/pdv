<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <p>
      Selecione as telas com os links a baixo      
    </p>
    <h3>Telas</h3>
    <ul>
      <li><ProdutosVue /></li>      
    </ul>
    <ListarProdutosVue />
  </div>
</template>

<script>
import ListarProdutosVue from './ListaProdutos.vue';
import ProdutosVue from './Produtos.vue';

export default {
  name: 'DashBoard',
  components: {
    ListarProdutosVue,
    ProdutosVue
  },
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
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
