const user =  require('./data/user') 

const calculate_age = require('./helpers/calculate-age')

// console.log(user.name);
// console.log(user.birth);
console.log(calculate_age(user));