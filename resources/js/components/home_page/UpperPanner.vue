<template>
  <div class="banner">
    <div class="parent">
      <v-container>
        <VRow>
          <v-col cols="6">
            <div class="cont">
              <h3><span>Huge Saving</span>on UHD Television</h3>
              <p class="hint">Sale up to 70% of on selected items</p>
              <v-btn
                variant="outlined"
                density="compact"
                height="50"
                width="160"
                style="border-radius: 30px; text-transform: none"
                >Shop Now</v-btn
              >
            </div>
          </v-col>
        </VRow>
      </v-container>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.banner {
  .parent {
    height: 390px;
    background-image: url("../../assets/images/banner-bg.jpg");
    background-size: cover;
    background-position: left top;
  }
  .cont {
    color: white;
    padding: 45px 0 0 150px;
  }
  h3 {
    font-size: 40px;
    font-weight: 900;
    span {
      color: aquamarine;
    }
  }
  .hint {
    margin: 20px 0;
  }
}
</style>
