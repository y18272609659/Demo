import Vue from 'vue'
import VueX from 'vuex'

Vue.use(VueX)

export default new VueX.Store({
  state: {
    loginName: '',
    nickname: '',
    kingdom: '',
    capitalX: '',
    capitalY: '',
    resource: {
      people: 0,
      food: 0,
      wood: 0,
      stone: 0,
      money: 0,
      area: 0,
    },
    buildingList: {},
    schedules: {},
    resourceTrans: {
      people: '人口',
      food: '食物',
      wood: '木材',
      stone: '石材',
      money: '金钱',
      area: '面积',
    },
  },
  getters: {
    doneTodos: state => {
      return state.todos.filter(todo => todo.done)
    },
    getTodoById: (state) => (id) => {
      return state.todos.find(todo => todo.id === id)
    }
  },
  mutations: {
    increment: state => state.count++,
    decrement: state => state.count--,

    // 资源数量随时间匀速增长
    setUpdate (state) {
      let Kind = ['people', 'food', 'wood', 'stone', 'money', 'area']
      Kind.forEach(MathUpdate)
      function MathUpdate (item) {
        let resource = state.resource
        let SecOutput = resource[item].output / 3600
        resource[item].value += Math.floor(SecOutput)
        resource[item].oddment += SecOutput - Math.floor(SecOutput)
        if (resource.people.oddment > 1) {
          state.resource[item].value += 1
          state.resource[item].oddment -= 1
        }
      }
    },

    // setUpdate (state) {
    //   let resource = state.resource
    //   const SecOutput = resource.people.output / 3600
    //   resource.people.value += Math.floor(SecOutput)
    //   resource.people.oddment += SecOutput - Math.floor(SecOutput)
    //   // console.log(resource.people.oddment)
    //   if (resource.people.oddment > 1) {
    //     state.resource.people.value += 1
    //     state.resource.people.oddment -= 1
    //   }

    // secUpdate: (state) => {
    //   // https://stackoverflow.com/questions/32422867/when-do-i-need-to-use-hasownproperty
    //
    //   Object.keys(state.resource).forEach(function (key) {
    //     let prod = state.resource[key].output * 1
    //     prod = (prod + '').split('.')
    //     state.resource[key].value += Number(prod[0])
    //     state.resource[key].oddment += Number(prod[1])
    //     if (state.resource[key].oddment > 2.5) {
    //       prod = (state.resource[key].oddment + '').split('.')
    //       state.resource[key].value += Number(prod[0])
    //       state.resource[key].oddment += Number(prod[1])
    //     }
    //   })
    // },

    // update-resource 资源数量随时间匀速增长 包含函数：setUpdate、update、以及resource-bar中的mounted
    // setUpdate (state) {
    //   // state.resource.people.value++ ( <= just a test-code)
    //   let resource = state.resource
    //   for (let k in resource) {
    //     resource[k].value++
    //   }
    // },

    /* 设定 */
    setUser (state, userData) {
      state.loginName = userData.nickname
      state.nickname = userData.nickname
      state.kingdom = userData.kingdom
      let capital = userData.capital.split(',')
      state.capitalX = capital[0]
      state.capitalY = capital[1]
    },

    setSchedules (state, shcedules) {
      state.schedules = shcedules
      for (let i = 0; i < shcedules.length; i++) {
        state.schedules[i].percent = 0
      }
    },

    setBuildingList (state, buildingList) {
      // 将已有建筑数量与建筑清单结合
      let buildingKeys = Object.keys(buildingList.building)
      let keys = ['farm', 'sawmill']
      for (let i = 0; i < buildingKeys.length; i++) {
        for (let ii = 0; ii < keys.length; ii++) {
          if (buildingKeys[i].indexOf(keys[ii]) !== -1) {
            let keyNumber = Number(buildingKeys[i].slice(-2)) - 1
            buildingList.list[keys[ii]][keyNumber].number = buildingList.building[buildingKeys[i]]
          }
        }
      }

      state.buildingList = buildingList.list
    },

    setResource (state, resourceData) {
      // 语义化资源名称
      let resourceTrans = [
        {key: 'people', name: '人口'},
        {key: 'food', name: '食物'},
        {key: 'wood', name: '木材'},
        {key: 'stone', name: '石材'},
        {key: 'money', name: '金钱'},
        {key: 'area', name: '面积'},
      ]
      for (let i = 0; i < resourceTrans.length; i++) {
        state.resource[resourceTrans[i].key] = {
          name: resourceTrans[i].name,
          value: resourceData[resourceTrans[i].key],
          oddment: resourceData[resourceTrans[i].key + 'Chip'],
          output: resourceData[resourceTrans[i].key + 'Output'],
        }
      }
    },
  },
  actions: {
    // update (context, interval) {
    //   if (interval > Math.ceil(new Date() / 1000) + 15) {
    //     context.commit('secUpdate')
    //   }
    // }

    update (context, interval) {
      setInterval(() => {
        context.commit('setUpdate')
      }, interval)
    }
  },
})
