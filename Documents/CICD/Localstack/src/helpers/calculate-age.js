const calculate_age = (user) => {
  let date_diff = new Date(Date.now() - user.birth.getTime()),
    age = Math.abs(date_diff.getUTCFullYear() - 1970);
  return age;
}

module.exports = calculate_age