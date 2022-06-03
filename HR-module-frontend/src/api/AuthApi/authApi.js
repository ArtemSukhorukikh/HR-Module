import {LoginAPIInstance, ApiInstance} from "@/api";

export const AuthApi = {
    login(login, password) {
        const url = '/auth'
        const data = {login, password}
        return LoginAPIInstance.post(url, data)
    },

    logout() {
      const url = '/logout'
      return ApiInstance.post(url)
    }
}