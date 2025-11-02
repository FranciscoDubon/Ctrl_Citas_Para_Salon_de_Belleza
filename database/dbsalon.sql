create database DBSalon;
use DBSalon;
-- ============================
-- TABLA ROL
-- ============================
CREATE TABLE Rol (
    idRol SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255)
);

-- ============================
-- TABLA EMPLEADO
-- ============================
CREATE TABLE Empleado (
    idEmpleado SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL,
    idRol INT NOT NULL,
    FOREIGN KEY (idRol) REFERENCES Rol(idRol)
);

-- ============================
-- TABLA CLIENTE
-- ============================
CREATE TABLE Cliente (
    idCliente SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correoElectronico VARCHAR(100) UNIQUE,
    clave VARCHAR(255) NOT NULL,
    perfil VARCHAR(100)
);

-- ============================
-- TABLA PERFILCLIENTE
-- ============================
CREATE TABLE PerfilCliente (
    idCliente SERIAL PRIMARY KEY,
    largoCabello VARCHAR(50),
    tinturado BOOLEAN,
    esmaltePrevio BOOLEAN,
    tipoEsmaltado VARCHAR(50),
    otrosTratamientos VARCHAR(255),
    FOREIGN KEY (idCliente) REFERENCES Cliente(idCliente)
);
-- ============================
-- TABLA ESTILISTA
-- ============================
CREATE TABLE Estilista (
    idEstilista SERIAL PRIMARY KEY,
    especialidad VARCHAR(100),
	FOREIGN KEY (idEstilista) REFERENCES Empleado(idEmpleado)
   
);

-- ============================
-- TABLA SERVICIO
-- ============================
CREATE TABLE Servicio (
    idServicio SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    precioBase FLOAT NOT NULL,
    duracionBase FLOAT NOT NULL
);

-- ============================
-- TABLA COMBO
-- ============================
CREATE TABLE Combo (
    idCombo SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precioTotal FLOAT
);

-- ============================
-- RELACI�N COMBO - SERVICIO (N:M)
-- ============================
CREATE TABLE ComboServicio (
    idCombo INT,
    idServicio INT,
    PRIMARY KEY (idCombo, idServicio),
    FOREIGN KEY (idCombo) REFERENCES Combo(idCombo),
    FOREIGN KEY (idServicio) REFERENCES Servicio(idServicio)
);

-- ============================
-- TABLA CITA
-- ============================
CREATE TABLE Cita (
    idCita SERIAL PRIMARY KEY,
    idCliente INT NOT NULL,
    idEstilista INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado VARCHAR(50),
    duracion FLOAT,
    FOREIGN KEY (idCliente) REFERENCES Cliente(idCliente),
    FOREIGN KEY (idEstilista) REFERENCES Estilista(idEstilista)
);

-- ============================
-- RELACI�N CITA - SERVICIO (N:M)
-- ============================
CREATE TABLE CitaServicio (
    idCita INT,
    idServicio INT,
    PRIMARY KEY (idCita, idServicio),
    FOREIGN KEY (idCita) REFERENCES Cita(idCita),
    FOREIGN KEY (idServicio) REFERENCES Servicio(idServicio)
);

-- ============================
-- TABLA PROMOCION
-- ============================
CREATE TABLE Promocion (
    idPromocion INT PRIMARY KEY SERIAL,
    descripcion VARCHAR(255),
    descuento FLOAT NOT NULL,
    fechaInicio DATE NOT NULL,
    fechaFin DATE NOT NULL
);

-- ============================
-- RELACI�N PROMOCION - SERVICIO (N:M)
-- ============================
CREATE TABLE PromocionServicio (
    idPromocion INT,
    idServicio INT,
    PRIMARY KEY (idPromocion, idServicio),
    FOREIGN KEY (idPromocion) REFERENCES Promocion(idPromocion),
    FOREIGN KEY (idServicio) REFERENCES Servicio(idServicio)
);

-- ============================
-- RELACI�N PROMOCION - COMBO (N:M)
-- ============================
CREATE TABLE PromocionCombo (
    idPromocion INT,
    idCombo INT,
    PRIMARY KEY (idPromocion, idCombo),
    FOREIGN KEY (idPromocion) REFERENCES Promocion(idPromocion),
    FOREIGN KEY (idCombo) REFERENCES Combo(idCombo)
);

-- ============================
-- TABLA REPORTE
-- ============================
CREATE TABLE Reporte (
    idReporte SERIAL PRIMARY KEY,
    tipo VARCHAR(100),
    fechaGeneracion DATE NOT NULL,
    idEmpleado INT NOT NULL,
    FOREIGN KEY (idEmpleado) REFERENCES Empleado(idEmpleado)
);

CREATE TABLE PasswordReset (
    idReset SERIAL PRIMARY KEY,  -- autoincremental
    tipoUsuario VARCHAR(20) NOT NULL CHECK (tipoUsuario IN ('Empleado','Cliente')),
    idUsuario INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,  -- el token debe ser �nico
    fechaExpiracion TIMESTAMP  NOT NULL,
    fechaCreacion TIMESTAMP  NOT NULL DEFAULT NOW()
);