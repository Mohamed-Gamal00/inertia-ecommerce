<template>
  <div class="top-offer bg-grey-lighten-4 py-9">
    <v-container fluid>
      <v-row>
        <v-col cols="4" class="py-0 pr-6">
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="parent"
              v-bind="props"
              style="overflow: hidden; border-radius: 7px"
            >
              <img
                src="@/assets/images/playstations.webp"
                :style="`width:100%;cursor:pointer;transition:0.5s all ease-in-out; scale: ${
                  isHovering ? 1.05 : 1
                }`"
                alt="playstations"
              />
            </div>
          </v-hover>
        </v-col>
        <v-col cols="4" class="py-0 pr-6">
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="parent"
              v-bind="props"
              style="overflow: hidden; border-radius: 7px"
            >
              <img
                src="@/assets/images/headset.webp"
                :style="`width:100%;cursor:pointer;transition:0.5s all ease-in-out; scale: ${
                  isHovering ? 1.05 : 1
                }`"
                alt="playstations"
              />
            </div>
          </v-hover>
        </v-col>
        <v-col cols="4" class="py-0">
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="parent"
              v-bind="props"
              style="overflow: hidden; border-radius: 7px"
            >
              <img
                src="@/assets/images/chairs.webp"
                :style="`width:100%;cursor:pointer;transition:0.5s all ease-in-out; scale: ${
                  isHovering ? 1.05 : 1
                }`"
                alt="playstations"
              />
            </div>
          </v-hover>
        </v-col>
      </v-row>
      <v-row class="mt-8">
        <v-col cols="6" class="mt-3 py-0">
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="parent pr-2"
              v-bind="props"
              style="overflow: hidden; height: 100%"
            >
              <img
                src="@/assets/images/iphones.webp"
                :style="`width:100%;height:100%;cursor:pointer;transition:0.5s all ease-in-out; scale: ${
                  isHovering ? 1.05 : 1
                }`"
                alt="playstations"
              />
            </div>
          </v-hover>
        </v-col>
        <v-col cols="6" class="mt-3 py-0">
          <v-hover v-slot="{ isHovering, props }">
            <div
              class="parent pl-2"
              v-bind="props"
              style="overflow: hidden; height: 100%"
            >
              <img
                src="@/assets/images/laptops.webp"
                :style="`width:100%;height:100%;cursor:pointer;transition:0.5s all ease-in-out; scale: ${
                  isHovering ? 1.05 : 1
                }`"
                alt="playstations"
              />
            </div>
          </v-hover>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
