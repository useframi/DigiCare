
export const GET_SERVICE_LIST = ({encounter_id}) => {return {path: `services/index_list?encounter_id=${encounter_id}`, method: 'GET'}}

export const GET_SERVICE_DETAILS = ({encounter_id,service_id}) => {return {path: `services/service-details?service_id=${service_id}&encounter_id=${encounter_id}`, method: 'GET'}}

export const SAVE_BILLING_DETAILS = () => {return {path: `billing-record/save-billing-details`, method: 'POST'}}

export const GET_BILLING_DETAILS = ({encounter_id}) => {return {path: `billing-record/edit-billing-detail?encounter_id=${encounter_id}`, method: 'GET'}}

