# Redux

声明： 推荐使用 `npm install @reduxjs/toolkit` ， 详细请看文档。



🐻 <u>Redux 复杂程度十足</u>

## 🐝 安装

```
npm install redux
```

浏览器安装 `Redux DevTools`

## 🐝 安装 Thunk

```
npm install --save redux-thunk
```

`App.js` 配置 , `Provider`

```react
import React, { Component } from "react";
import Header from "./common/header/index";
import { Provider } from "react-redux";
import store from "./store";
import Login from './pages/login';
import Write from './pages/Write/index'
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "./pages/home";
import Detail from "./pages/detail";

class App extends Component {
  render() {
    return (
      <Provider store={store}>
        <BrowserRouter>
        <Header />
          <Routes>
            <Route path="/" exact element={<Home />} />
            <Route path="/login" exact element={< Login />} />
            <Route path="/write" exact element={< Write />} />
            <Route path="/detail/:id" exact element={<Detail />} />
          </Routes>
        </BrowserRouter>
      </Provider>
    );
  }
}

export default App;
```





## 🙉 例子

创建 `store` 文件



### 主 `store` 文件

`index.js` 和 `reducer.js`

`index.js` 

```react
import { createStore, compose, applyMiddleware } from "redux";
import thunk from "redux-thunk";
import reducer from "./reducer";

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const store = createStore(reducer, composeEnhancers(applyMiddleware(thunk)));

export default store;
```

 `reducer.js`

```react
import { combineReducers } from "redux-immutable";
import { reducer as headerReducer } from "../common/header/store";
import { reducer as homeReducer } from "../pages/home/store";
import { reducer as detailReducer } from '../pages/detail/store/'
import { reducer as loginReducer } from '../pages/login/store'

const reducer = combineReducers({
  header: headerReducer,
  home: homeReducer,
  detail:detailReducer,
  login:loginReducer,
});

export default reducer;
```





### 副 `store` 文件

`index.js` 和 `reducer.js` 和 `actionTypes.js` 和 `actionCreators.js`

`index.js`

```react
import reducer from "./reducer";
import * as actionCreators from './actionCreators'
import * as actionType from './actionType'

export { reducer,actionCreators,actionType };
```

`reducer.js`

```react
import { fromJS } from "immutable";
import * as actionType from './actionType'

const defaultState = fromJS({
    topicList: [],
    ListItem:[],
    recommimg:[],
    ListPage:1,
    scrollGoBack:false
});

const calculate = (state = defaultState, action) => {
  switch (action.type) {
    case actionType.CHANGE_HOME_DATA:
        return state.merge({
            topicList:fromJS(action.topicList),
            ListItem:fromJS(action.ListItem),
            recommimg:fromJS(action.recommimg)
        });
    case actionType.ADD_ARTICLE_LIST:
        return state.merge({
            ListItem:state.get('ListItem').concat(action.list),
            ListPage:action.nextPage
        });
    case actionType.GET_BACK_TOP:
        return state.set('scrollGoBack',action.show)
    default:
      return state;
  }
};

export default calculate;
```

`actionTypes.js`

```react
export const CHANGE_INPUT = 'changeInput/CHANGE_INPUT'
export const ADD_ITEM = 'addItem/ADD_ITEM'
export const DELETE_ITEM = 'deleteItem/DELETE_ITEM'
export const GET_DETAIL_DATA = 'header/GET_DETAIL_DATA';
```

`actionCreators.js`

```react
import axios from "axios";
import * as actionType from './actionType'
import { fromJS } from 'immutable';

export const changeInputAction = (value) => ({
	type: actionType.CHANGE_INPUT,
	value
})

export const addItemAction = () => ({
	type: actionType.ADD_ITEM
})

export const deleteItemAction = (index) => ({
	type: actionType.DELETE_ITEM,
	index
})

export const getHomeInfo = () => {
    return (dispatch) => {
        axios.get('/api/home.json').then((res)=>{
            const result = res.data.data;
            dispatch(changeHomeDate(result))
        })
    }
};

const changeHomeDate = (result) => ({
    type:actionType.CHANGE_HOME_DATA,
    topicList:result.topicList,
    ListItem:result.ListItem,
    recommimg:result.recommimg
});

export const getmorelist =(page)=>{
    return (dispatch) =>{
        axios.get('/api/get.json?page=' + page).then((res)=>{
            const result = res.data.data;
            /* console.log(result); */
            dispatch(addHomeList(result,page + 1));
            
        })
    }
};

const addHomeList = (list,nextPage) => ({
    type:actionType.ADD_ARTICLE_LIST,
    list:fromJS(list), /* 只能list，要concat的话 */
    nextPage
})

export const getBackTop = (show) => ({
    type:actionType.GET_BACK_TOP,
    show
})
```

`前端 ` `connect`

```react
import React, { PureComponent } from "react";
import Topic from "./components/Topic";
import Writer from "./components/Writer";
import Recommend from "./components/Recommend";
import List from "./components/List";
import { HomeWrapper, HomeLeft, HomeRight,BackTop } from "./style";
import { connect } from 'react-redux';
import { actionCreators } from './store';


class Home extends PureComponent {

  componentDidMount(){
      this.props.changeHomeDate();
      this.bindEvent();
  };

  bindEvent(){
    window.addEventListener('scroll',this.props.getBack);
  }

  handleBackTop(){
    window.scrollTo(0,0);
  }

  render() {
    const {showScroll} = this.props;
    return (
      <HomeWrapper>
        <HomeLeft>
          <img
            className="change_img"
            src="https://i.ytimg.com/vi/z7_9XW_IUYM/maxresdefault.jpg"
            alt=""
          />
          <Topic />
          <List />
        </HomeLeft>
        <HomeRight>
        <Recommend />
          <Writer />
          
        </HomeRight>
        {showScroll? <BackTop onClick={this.handleBackTop}><h3>顶部</h3></BackTop> : null}
        
      </HomeWrapper>
    );
  }
};

const mapState = (state) => ({
  showScroll:state.getIn(['home','scrollGoBack'])
})

const mapDispatch = (dispatch) => ({
  changeHomeDate(){
    dispatch(actionCreators.getHomeInfo())
  },
  getBack(){
    if(document.documentElement.scrollTop > 200){
      dispatch(actionCreators.getBackTop(true));
    }else{
      dispatch(actionCreators.getBackTop(false));
    }
  }
});

export default connect(mapState,mapDispatch)(Home);
```















