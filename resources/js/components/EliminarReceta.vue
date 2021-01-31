<template>
    <input
        type="submit"
        class="btn btn-danger d-block w-100 mb-2"
        value="Eliminar"
        v-on:click="eliminarReceta">
</template>

<script>
    export default {
        props: ['recetaId'],
        methods: {
            eliminarReceta(){
                this.$swal({
                    title: 'Estás seguro?',
                    text: 'Vas a eliminar una receta, este proceso no se puede revertir',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo'
                }).then((result) => {
                    if (result.value) {
                        const params = {
                            id: this.recetaId
                        }
                        axios.post(`/recetas/${this.recetaId}`, {params, _method: 'delete'})
                            .then(resp => {
                                this.$swal({
                                    title: 'Eliminado!',
                                    text: 'La receta fue eliminada.',
                                    icon: 'success'
                                });

                                this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                            })
                            .catch(error => {
                                console.log(error);
                            })

                    }
                })
            }
        }
    }
</script>
