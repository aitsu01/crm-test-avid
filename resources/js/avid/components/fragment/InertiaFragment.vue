<script setup lang="ts">
type PagePayload = {
  component: string
  props: Record<string, any>
  url?: string
  version?: string | null
}

const props = defineProps<{
  route: string
  method?: 'GET' | 'POST'
  payload?: Record<string, any> | null
  headers?: Record<string, string> | null
}>()

const loading = ref(true)
const error = ref<string | null>(null)
const page = ref<PagePayload | null>(null)
const ResolvedComponent = shallowRef<any>(null)

const method = computed(() => props.method ?? 'GET')

const pages = import.meta.glob('../../../pages/**/*.vue')

function normalizeComponentName(name: string) {
  return name.replace(/\.vue$/i, '')
}

async function resolvePageComponent(name: string) {
  const normalized = normalizeComponentName(name)

  const exactSuffix = `/${normalized}.vue`

  const key = Object.keys(pages).find((k) => k.endsWith(exactSuffix))

  if (!key) {
    throw new Error(`Inertia Page not found: ${normalized}`)
  }

  const mod: any = await pages[key]()
  return mod.default
}

async function load() {
  console.log('reload');
  loading.value = true
  error.value = null
  page.value = null
  ResolvedComponent.value = null

  try {
    const res = await fetch(props.route, {
      method: method.value,
      headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(props.headers ?? {}),
        ...(method.value !== 'GET' ? { 'Content-Type': 'application/json' } : {}),
      },
      body: method.value !== 'GET' ? JSON.stringify(props.payload ?? {}) : undefined,
      credentials: 'same-origin',
    })

    if (!res.ok) throw new Error(`HTTP ${res.status}`)

    const data = (await res.json()) as PagePayload
    page.value = data

    ResolvedComponent.value = await resolvePageComponent(data.component)
  } catch (e: any) {
    error.value = e?.message ?? 'Unknown error'
  } finally {
    loading.value = false
  }
}

onMounted(load)
watch(() => props.route, () => load())
</script>

<template>
  <slot v-if="loading" name="loading" />

  <div v-else-if="error">
    <slot name="error" :error="error">
      <div class="text-red-600">Errore: {{ error }}</div>
    </slot>
  </div>

  <component
    v-else
    :is="ResolvedComponent"
    v-bind="page?.props ?? {}"
  />
</template>