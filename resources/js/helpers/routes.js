export const formatQuery = (query) => {
  // format object parameters to uri query
  let formatedParameters = '';
  Object.keys(query).forEach((key, i) => {
      if (i === 0) {
          formatedParameters += `?${key}=${query[key]}`;
      } else {
          formatedParameters += `&${key}=${query[key]}`
      }
  });
  return formatedParameters;
}