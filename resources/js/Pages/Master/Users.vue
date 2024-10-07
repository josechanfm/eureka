<template>
  <AdminLayout title="User Management">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User Management
      </h2>
    </template>

    <template #submenu>
      <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                <Link
                  :href="route('master.dashboard')"
                  :class="[
                    route().current('master.dashboard')
                      ? 'border-indigo-500 text-gray-900'
                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium'
                  ]"
                >
                  Dashboard
                </Link>
                <Link
                  :href="route('master.configs.index')"
                  :class="[
                    route().current('master.configs.*')
                      ? 'border-indigo-500 text-gray-900'
                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium'
                  ]"
                >
                  Config
                </Link>
                <Link
                  :href="route('master.users.index')"
                  :class="[
                    route().current('master.users.*')
                      ? 'border-indigo-500 text-gray-900'
                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium'
                  ]"
                >
                  Users
                </Link>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-bold">Users</h2>
              <a-button type="primary" @click="showModal('create')">
                Create User
              </a-button>
            </div>

            <a-table :dataSource="users" :columns="columns">
              <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'action'">
                  <a-space size="small">
                    <a-button type="primary" @click="showModal('edit', record)">Edit</a-button>
                    <a-popconfirm
                      title="Are you sure you want to delete this user?"
                      ok-text="Yes"
                      cancel-text="No"
                      @confirm="deleteUser(record.id)"
                    >
                      <a-button type="danger">Delete</a-button>
                    </a-popconfirm>
                  </a-space>
                </template>
              </template>
            </a-table>
          </div>
        </div>
      </div>
    </div>

    <a-modal
      :visible="modalVisible"
      :title="modalMode === 'create' ? 'Create User' : 'Edit User'"
      @ok="handleOk"
      @cancel="handleCancel"
    >
      <a-form :model="formState" :rules="rules" ref="formRef">
        <a-form-item label="Name" name="name">
          <a-input v-model:value="formState.name" />
        </a-form-item>
        <a-form-item label="Email" name="email">
          <a-input v-model:value="formState.email" />
        </a-form-item>
        <a-form-item label="Password" name="password" v-if="modalMode === 'create'">
          <a-input-password v-model:value="formState.password" />
        </a-form-item>
        <a-form-item label="Roles" name="roles">
          <a-select v-model:value="formState.roles" mode="multiple">
            <a-select-option v-for="role in roles" :key="role.id" :value="role.name">
              {{ role.name }}
            </a-select-option>
          </a-select>
        </a-form-item>
      </a-form>
    </a-modal>
  </AdminLayout>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

export default defineComponent({
  components: {
    AdminLayout,
    Link,
  },
  props: {
    users: Array,
    roles: Array,
  },
  setup(props) {
    const modalVisible = ref(false)
    const modalMode = ref('create')
    const formRef = ref(null)
    const formState = reactive({
      id: null,
      name: '',
      email: '',
      password: '',
      roles: [],
    })

    const form = useForm({
      id: null,
      name: '',
      email: '',
      password: '',
      roles: [],
    })

    const rules = {
      name: [{ required: true, message: 'Please input the name', trigger: 'blur' }],
      email: [
        { required: true, message: 'Please input the email', trigger: 'blur' },
        { type: 'email', message: 'Please input a valid email', trigger: 'blur' },
      ],
      password: [{ required: true, message: 'Please input the password', trigger: 'blur' }],
      roles: [{ required: true, type: 'array', message: 'Please select at least one role', trigger: 'change' }],
    }

    const columns = [
      { title: 'Name', dataIndex: 'name', key: 'name' },
      { title: 'Email', dataIndex: 'email', key: 'email' },
      { title: 'Roles', dataIndex: 'roles', key: 'roles',
        customRender: ({ text }) => text.map(role => role.name).join(', ')
      },
      { title: 'Action', key: 'action' },
    ]

    const showModal = (mode, record = null) => {
      modalMode.value = mode
      if (mode === 'edit' && record) {
        Object.assign(formState, {
          ...record,
          roles: record.roles.map(role => role.name)
        })
        form.id = record.id
        form.name = record.name
        form.email = record.email
        form.roles = record.roles.map(role => role.name)
      } else {
        Object.assign(formState, { id: null, name: '', email: '', password: '', roles: [] })
        form.reset()
      }
      modalVisible.value = true
    }

    const handleOk = () => {
      formRef.value.validate().then(() => {
        if (modalMode.value === 'create') {
          createUser()
        } else {
          updateUser()
        }
      }).catch(error => {
        console.log('Validation failed:', error)
      })
    }

    const handleCancel = () => {
      modalVisible.value = false
    }

    const createUser = () => {
      form.post(route('master.users.store'), {
        preserveScroll: true,
        onSuccess: () => {
          modalVisible.value = false
          form.reset()
        },
      })
    }

    const updateUser = () => {
      form.put(route('master.users.update', formState.id), {
        preserveScroll: true,
        onSuccess: () => {
          modalVisible.value = false
          form.reset()
        },
      })
    }

    const deleteUser = (id) => {
      if (confirm('Are you sure you want to delete this user?')) {
        useForm().delete(route('master.users.destroy', id), {
          preserveScroll: true,
        })
      }
    }

    return {
      modalVisible,
      modalMode,
      formRef,
      formState,
      form,
      rules,
      columns,
      showModal,
      handleOk,
      handleCancel,
      deleteUser,
    }
  },
})
</script>