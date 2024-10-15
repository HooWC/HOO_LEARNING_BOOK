# Vue3 API 发送请求



```
onMounted(() => {
	getList()
})

const getList = async () => {
	const res = await axios.get('/list')
	list.value = res.data
}
```



```
const onDelete = async (id) => {
	await axios.delete('/del/${id}')
	getList()
}
```



```
 onMounted(async() => {
        getInvoices()
    })

 const getInvoices = async() => {
     let response = await axios.get("/api/get_all_invoice")
     //console.log('response',response)
     invoices.value = response.data.invoices
 }
 
 const search = async() => {
     let response = await axios.get('/api/search_invoice?s='+searchInvoice.value)
     //console.log('response',response.data.invoices)
     invoices.value = response.data.invoices
 }
```

















