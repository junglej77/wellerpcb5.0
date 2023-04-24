<?php
function email_SMTP()
{
?>
    <div id="app">
        <h2>设置接受邮箱的账号</h2>
        <el-form ref="Form" :model="form">
            <el-form-item label="email" :label-width="formLabelWidth">
                <el-input v-model="form.sectionType" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="password" :label-width="formLabelWidth">
                <el-input v-model="form.password" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="Host" :label-width="formLabelWidth">
                <el-input v-model="form.Host" placeholder="smtp.example.com" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="SMTPAuth" :label-width="formLabelWidth">
                <el-switch v-model="form.SMTPAuth" size="large" active-text="true" inactive-text="false" />
            </el-form-item>
            <el-form-item label="SMTPSecure" :label-width="formLabelWidth">
                <el-radio-group v-model="form.SMTPSecure">
                    <el-radio :label="">none</el-radio>
                    <el-radio :label="tls">tls</el-radio>
                    <el-radio :label="ssl">ssl</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="Port" :label-width="formLabelWidth">
                <el-input-number v-model="form.Port" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">更新</el-button>
            </el-form-item>
        </el-form>
    </div>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    userInfo: {},
                    form: {
                        email: '',
                        password: '',
                        Host: '',
                        SMTPAuth: '',
                        SMTPSecure: '',
                        Port: '',
                    },
                    formLabelWidth: '120px',
                }
            },
            mounted() {

            },
            methods: {
                async submit() {
                    axios.post('/wp-json/pageSections/create', this.form)
                        .then(response => {
                            this.dialogFormVisible = false
                        }).catch(error => {
                            console.error(error);
                        });
                },
            }
        });
        app.use(ElementPlus).mount('#app')
    </script>
<?php
} ?>