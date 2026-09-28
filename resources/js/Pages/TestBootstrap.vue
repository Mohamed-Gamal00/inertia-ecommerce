<template>
  <div>
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-3">Bootstrap Migration Test</h1>
            <p class="lead mb-4">
              This page demonstrates the new Bootstrap layout with all components working correctly.
            </p>
            <div class="d-flex gap-2">
              <BButton variant="light" size="lg" @click="showToast">
                <i class="bi bi-check-circle me-2"></i>
                Test Toast
              </BButton>
              <BButton variant="outline-light" size="lg" @click="modalOpen = true">
                <i class="bi bi-box-arrow-up-right me-2"></i>
                Test Modal
              </BButton>
            </div>
          </div>
          <div class="col-lg-6 text-center mt-4 mt-lg-0">
            <i class="bi bi-check-circle-fill" style="font-size: 200px; opacity: 0.2;"></i>
          </div>
        </div>
      </div>
    </section>

    <!-- Components Demo -->
    <section class="py-5">
      <div class="container">
        <h2 class="mb-4">Bootstrap Components Demo</h2>

        <div class="row g-4">

          <!-- Buttons -->
          <div class="col-md-6">
            <BCard title="Buttons" shadow hoverable>
              <div class="d-flex flex-wrap gap-2">
                <BButton variant="primary">Primary</BButton>
                <BButton variant="secondary">Secondary</BButton>
                <BButton variant="success">Success</BButton>
                <BButton variant="danger">Danger</BButton>
                <BButton variant="warning">Warning</BButton>
                <BButton variant="info">Info</BButton>
                <BButton variant="light">Light</BButton>
                <BButton variant="dark">Dark</BButton>
              </div>

              <hr>

              <div class="d-flex flex-wrap gap-2">
                <BButton variant="primary" size="sm">Small</BButton>
                <BButton variant="primary">Medium</BButton>
                <BButton variant="primary" size="lg">Large</BButton>
              </div>

              <hr>

              <div class="d-flex flex-wrap gap-2">
                <BButton variant="primary" icon="heart">With Icon</BButton>
                <BButton variant="success" :loading="true">Loading</BButton>
                <BButton variant="secondary" outline>Outline</BButton>
              </div>
            </BCard>
          </div>

          <!-- Badges -->
          <div class="col-md-6">
            <BCard title="Badges & Alerts" shadow hoverable>
              <div class="mb-3">
                <BBadge variant="primary" class="me-1">Primary</BBadge>
                <BBadge variant="secondary" class="me-1">Secondary</BBadge>
                <BBadge variant="success" class="me-1">Success</BBadge>
                <BBadge variant="danger" class="me-1">Danger</BBadge>
                <BBadge variant="warning" class="me-1">Warning</BBadge>
                <BBadge variant="info" class="me-1">Info</BBadge>
              </div>

              <div class="mb-3">
                <BBadge variant="primary" pill class="me-1">Pill Badge</BBadge>
                <BBadge variant="success" icon="check-circle" class="me-1">With Icon</BBadge>
                <BBadge variant="danger" closeable @close="console.log('closed')">Closeable</BBadge>
              </div>

              <BAlert variant="success" :model-value="true" dismissible icon="check-circle">
                This is a success alert with an icon!
              </BAlert>

              <BSpinner variant="primary" class="me-2" />
              <BSpinner type="grow" variant="success" />
            </BCard>
          </div>

          <!-- Forms -->
          <div class="col-md-6">
            <BCard title="Form Components" shadow hoverable>
              <BInput
                v-model="formData.name"
                label="Name"
                placeholder="Enter your name"
                prepend-icon="person"
              />

              <BInput
                v-model="formData.email"
                type="email"
                label="Email"
                placeholder="your@email.com"
                prepend-icon="envelope"
              />

              <BSelect
                v-model="formData.country"
                label="Country"
                :options="countries"
                placeholder="Select a country"
              />

              <BTextarea
                v-model="formData.message"
                label="Message"
                placeholder="Enter your message"
                rows="3"
                maxlength="200"
                show-count
              />

              <BCheckbox v-model="formData.agree" label="I agree to terms and conditions" />

              <BButton variant="primary" block>Submit Form</BButton>
            </BCard>
          </div>

          <!-- Tabs & Pagination -->
          <div class="col-md-6">
            <BCard title="Tabs & Pagination" shadow hoverable>
              <BTabs
                v-model="activeTab"
                :tabs="tabs"
              >
                <template #tab-0>
                  <p>This is the content for the Home tab.</p>
                </template>
                <template #tab-1>
                  <p>This is the content for the Profile tab.</p>
                </template>
                <template #tab-2>
                  <p>This is the content for the Settings tab.</p>
                </template>
              </BTabs>

              <hr>

              <BPagination
                v-model:current-page="currentPage"
                :total-pages="10"
                :max-visible-pages="5"
              />
            </BCard>
          </div>

          <!-- Grid System -->
          <div class="col-12">
            <BCard title="Bootstrap Grid System" shadow>
              <Row class="mb-3">
                <Col cols="12" md="4" class="bg-primary text-white p-3 mb-2 mb-md-0">Col 4</Col>
                <Col cols="12" md="4" class="bg-secondary text-white p-3 mb-2 mb-md-0">Col 4</Col>
                <Col cols="12" md="4" class="bg-success text-white p-3">Col 4</Col>
              </Row>

              <Row>
                <Col cols="12" sm="6" md="3" class="bg-info text-white p-3 mb-2">Col 3</Col>
                <Col cols="12" sm="6" md="3" class="bg-warning text-white p-3 mb-2">Col 3</Col>
                <Col cols="12" sm="6" md="3" class="bg-danger text-white p-3 mb-2">Col 3</Col>
                <Col cols="12" sm="6" md="3" class="bg-dark text-white p-3 mb-2">Col 3</Col>
              </Row>
            </BCard>
          </div>

        </div>
      </div>
    </section>

    <!-- Modal -->
    <BModal
      v-model="modalOpen"
      title="Test Modal"
      size="lg"
      centered
    >
      <p>This is a Bootstrap modal dialog!</p>
      <p>It supports different sizes, can be centered, and has backdrop options.</p>

      <template #footer>
        <BButton variant="secondary" @click="modalOpen = false">Close</BButton>
        <BButton variant="primary" @click="modalOpen = false">Save Changes</BButton>
      </template>
    </BModal>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import {
  BButton, BCard, BInput, BSelect, BTextarea, BCheckbox,
  BBadge, BAlert, BSpinner, BTabs, BPagination, BModal
} from '../components/bootstrap';
import { Row, Col } from '../components/bootstrap';
import { useToast } from '../composables/useToast';

const { success, error, info, warning } = useToast();

const formData = ref({
  name: '',
  email: '',
  country: '',
  message: '',
  agree: false
});

const countries = [
  { label: 'Saudi Arabia', value: 'sa' },
  { label: 'United Arab Emirates', value: 'ae' },
  { label: 'Egypt', value: 'eg' },
  { label: 'Jordan', value: 'jo' }
];

const activeTab = ref(0);
const currentPage = ref(1);
const modalOpen = ref(false);

const tabs = [
  { title: 'Home', icon: 'house' },
  { title: 'Profile', icon: 'person', badge: '3' },
  { title: 'Settings', icon: 'gear' }
];

const showToast = () => {
  const toasts = [
    { fn: success, msg: 'Success! Operation completed.' },
    { fn: error, msg: 'Error! Something went wrong.' },
    { fn: warning, msg: 'Warning! Please check your input.' },
    { fn: info, msg: 'Info: This is an informational message.' }
  ];

  const random = toasts[Math.floor(Math.random() * toasts.length)];
  random.fn(random.msg);
};
</script>

<style scoped>
.display-4 {
  font-size: 3.5rem;
  font-weight: 300;
  line-height: 1.2;
}

.lead {
  font-size: 1.25rem;
  font-weight: 300;
}

@media (max-width: 768px) {
  .display-4 {
    font-size: 2.5rem;
  }
}
</style>
