<template>
  <div>
      <h1>Welcome to Vue App</h1>
      <button @click="counter ++">Click me {{ counter }}</button>
  </div>
</template>

<script>
export default {
    data : () => {
        return {
            counter: 0
        }
    }
}
</script>