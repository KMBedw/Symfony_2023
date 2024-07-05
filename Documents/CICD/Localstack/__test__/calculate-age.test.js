const user = require('../src/data/user');
const calculate_age = require('../src/helpers/calculate-age');

describe('unit test suite', () => {
  it('should correctly calculate the age', () => {
    // Calculez l'âge en fonction de la date de naissance et de l'année actuelle
    const age = calculate_age(user);
    const currentYear = new Date().getUTCFullYear();
    const expectedAge = currentYear - 1992; // Remplacez 1992 par l'année de naissance si elle est différente

    expect(age).toBe(expectedAge);
  });
});
