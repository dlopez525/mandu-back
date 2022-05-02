### EndPoints

- [GET] `https://daniellopez.dev/divisions/get-divisions` - Consultar Divisiones.
- [GET] `https://daniellopez.dev/divisions/get-division/{id}` - Consultar Division por ID.
- [POST] `https://daniellopez.dev/divisions/store` - Crear Division.
    - name => requerido -  min:3  -  max:45.
    - level => requerido|integer|min:1.
    - number_collaborators => requerido - integer -  min:1,  .
    - ambassador_id => requerido - integer -  min:1.
    - superior_division_id => opcional,
    - sub_divisions => array - string,
- [POST] `https://daniellopez.dev/divisions/update/{id}` - Actualizar una Division.
    - name => requirido -  min:3  -  max:45.
    - level => requirido|integer|min:1.
    - number_collaborators => requerido - integer -  min:1,  .
    - ambassador_id => requerido - integer -  min:1.
    - superior_division_id => opcional,
    - sub_divisions => array - string,
- [POST] `https://daniellopez.dev/divisions/delete/{id}` - Eliminar una Division.
