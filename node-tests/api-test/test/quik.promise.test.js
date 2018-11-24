const axios = require('axios')
const {expect} = require('chai')

const config = require('../config.js')
const baseUrl = config.api_base_url

const db = require('./fixtures/User')

// ## api url
const createUrl = `${baseUrl}/quick/test`

before(()=>{
    return new Promise((resolve, reject) => {
        return  resolve('hi')
    }).then(()=>{
        console.log('server is running')
    })
})

describe('express rest api server', () => {
    let id

    it('posts an object ddd', () => {
        return axios
            .post(createUrl, db.createData)
            .then(response=>response.data)
            .then((body) => {
                /*
                expect(body.length).to.eql(1)
                expect(body[0]._id.length).to.eql(24)
                id = body[0]._id
                */
                console.log(body)
            })
    })

    /*
    it('retrieves an object', () => {
        return axios.get(`http://localhost:${port}/collections/test/${id}`)
            .then(response=>response.data)
            .then((body) => {
                // console.log(body)
                expect(typeof body).to.eql('object')
                expect(body._id.length).to.eql(24)
                expect(body._id).to.eql(id)
                expect(body.name).to.eql('John')
            })
    })

    it('retrieves a collection', () => {
        return axios.get(`http://localhost:${port}/collections/test`)
            .then(response=>response.data)
            .then((body) => {
                // console.log(body)
                expect(body.length).to.be.above(0)
                expect(body.map((item) => {return item._id})).to.contain(id)
            })
    })

    it('updates an object', () => {
        return axios
            .put(`http://localhost:${port}/collections/test/${id}`, {name: 'Peter', email: 'peter@yahoo.com'})
            .then(response=>response.data)
            .then((body) =>{
                // console.log(body, e)
                expect(typeof body).to.eql('object')
                expect(body).to.eql({ msg: 'success' })
            })
    })

    it('checks an updated object', () => {
        return axios.get(`http://localhost:${port}/collections/test/${id}`)
            .then(response=>response.data)
            .then((body) => {
                // console.log(body)
                expect(typeof body).to.eql('object')
                expect(body._id.length).to.eql(24)
                expect(body._id).to.eql(id)
                expect(body.name).to.eql('Peter')
            })
    })
    it('removes an object', () => {
        return axios.delete(`http://localhost:${port}/collections/test/${id}`)
            .then(response=>response.data)
            .then((body) => {
                // console.log(body)
                expect(typeof body).to.eql('object')
                expect(body).to.eql({ msg: 'success' })
            })
    })
    it('checks an removed object', () => {
        return axios.get(`http://localhost:${port}/collections/test/`)
            .then(response=>response.data)
            .then((body) => {
                // console.log(body)
                expect(body.map(item=>item._id)).not.to.eql(id)
            })
    })
    */
})
