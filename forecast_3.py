#C:\Users\asus\AppData\Local\Programs\Python\Python39\python.exe

import scipy
import pandas as pd
import numpy as np
import mysql.connector
import tensorflow as tf

from tensorflow import keras
from tensorflow.keras import Sequential, layers, callbacks
from tensorflow.keras.layers import Activation,Dense, LSTM, Dropout
from tensorflow.keras.optimizers import Adam
from keras.preprocessing.sequence import TimeseriesGenerator
from tensorflow.keras.callbacks import EarlyStopping

from sklearn.preprocessing import MinMaxScaler
from sklearn.model_selection import train_test_split,KFold
from sklearn import metrics

mydb = mysql.connector.connect(
    host = "localhost",
    database = "water quality",
    user = "root",
    password = ""
)
query = "SELECT * FROM water_quality_data WHERE FISH_TANK_NUMBER = 3"
df = pd.read_sql(query, con=mydb)

#Fix random seed for reproducibility
np.random.seed(1234)

# Fill missing values with median column values
df.fillna(df.median(), inplace=True)

#Predict DO
X = df.iloc[:,[3,4]]
Y = df.loc[:,['DISSOLVED_OXYGEN']]

Z = X.values 
min_max_scaler = MinMaxScaler(feature_range = (0,1))
X_scaled = min_max_scaler.fit_transform(Z)
X = pd.DataFrame(X_scaled)

ZZ = Y.values 
min_max_scaler = MinMaxScaler(feature_range = (0,1))
Y_scaled = min_max_scaler.fit_transform(ZZ)
Y = pd.DataFrame(Y_scaled)

trainX = []
trainY = []

n_future = 1   # Number of days we want to look into the future based on the past days.
n_past = 7  # Number of past days we want to use to predict the future.
#Reformat input data into a shape: (n_samples x timesteps x n_features)
for i in range(n_past, len(X_scaled) - n_future +1):
    trainX.append(X_scaled[i - n_past:i, 0:X_scaled.shape[1]])
    trainY.append(X_scaled[i + n_future - 1:i + n_future, 0])

trainX, trainY = np.array(trainX), np.array(trainY)



X_train, X_test, y_train, y_test = train_test_split(trainX, trainY, test_size = 0.2, random_state = 0)
    
lstm_model = Sequential()

lstm_model.add(LSTM(256, input_shape=(trainX.shape[1], trainX.shape[2]), activation='relu', 
                        kernel_initializer='lecun_uniform', return_sequences=True))
lstm_model.add(LSTM(128, activation='relu', return_sequences=False))
lstm_model.add(Dense(1))

lstm_model.compile(loss='mean_squared_error', optimizer='adam',metrics =["mae"])
    
early_stop = keras.callbacks.EarlyStopping(monitor='loss', patience=2, verbose=1)

history_lstm_model = lstm_model.fit(X_train, y_train, epochs=100, batch_size=32, shuffle=False, callbacks=[early_stop])
    
  

lstm_model.save('Model/model3_do.h5')
keras.models.load_model('Model/model3_do.h5')
train_dates = pd.to_datetime(df['DATE_TIME'])
n_past = 1
n_days_for_prediction= 8


prediction_do = lstm_model.predict(X_train[-n_days_for_prediction:])
prediction_copies_do = np.repeat(prediction_do, X_train.shape[1], axis=-1)
y_pred_future_do = min_max_scaler.inverse_transform(prediction_copies_do)[:,0]
y_pred_future_do = np.round(y_pred_future_do, decimals=2)

#Predict PH
X = df.iloc[:,[3,5]]
Y = df.loc[:,['PH_VALUE']]

Z = X.values 
min_max_scaler = MinMaxScaler(feature_range = (0,1))
X_scaled = min_max_scaler.fit_transform(Z)
X = pd.DataFrame(X_scaled)

ZZ = Y.values 
min_max_scaler = MinMaxScaler(feature_range = (0,1))
Y_scaled = min_max_scaler.fit_transform(ZZ)
Y = pd.DataFrame(Y_scaled)

trainX = []
trainY = []

n_future = 1   # Number of days we want to look into the future based on the past days.
n_past = 7  # Number of past days we want to use to predict the future.
#Reformat input data into a shape: (n_samples x timesteps x n_features)
for i in range(n_past, len(X_scaled) - n_future +1):
    trainX.append(X_scaled[i - n_past:i, 0:X_scaled.shape[1]])
    trainY.append(X_scaled[i + n_future - 1:i + n_future, 0])

trainX, trainY = np.array(trainX), np.array(trainY)


X_train, X_test, y_train, y_test = train_test_split(trainX, trainY, test_size = 0.2, random_state = 0)
    
lstm_model = Sequential()

lstm_model.add(LSTM(256, input_shape=(trainX.shape[1], trainX.shape[2]), activation='relu', 
                        kernel_initializer='lecun_uniform', return_sequences=True))
lstm_model.add(LSTM(128, activation='relu', return_sequences=False))
lstm_model.add(Dense(1))

lstm_model.compile(loss='mean_squared_error', optimizer='adam',metrics =["mae"])
    
early_stop = keras.callbacks.EarlyStopping(monitor='loss', patience=2, verbose=1)

history_lstm_model = lstm_model.fit(X_train, y_train, epochs=100, batch_size=32, shuffle=False, callbacks=[early_stop])
    

lstm_model.save('Model/model3_ph.h5')
keras.models.load_model('Model/model3_ph.h5')
train_dates = pd.to_datetime(df['DATE_TIME'])
n_past = 1
n_days_for_prediction= 8


prediction_ph = lstm_model.predict(X_train[-n_days_for_prediction:])
prediction_copies_ph = np.repeat(prediction_ph, X_train.shape[1], axis=-1)
y_pred_future_ph = min_max_scaler.inverse_transform(prediction_copies_ph)[:,0]
y_pred_future_ph = np.round(y_pred_future_ph, decimals=2)

#Predict Temperature
X = df.iloc[:,[4,5]]
Y = df.loc[:,['WATER_TEMPERATURE']]

Z = X.values 
min_max_scaler = MinMaxScaler(feature_range = (0,1))
X_scaled = min_max_scaler.fit_transform(Z)
X = pd.DataFrame(X_scaled)

ZZ = Y.values 
min_max_scaler = MinMaxScaler(feature_range = (0,1))
Y_scaled = min_max_scaler.fit_transform(ZZ)
Y = pd.DataFrame(Y_scaled)

trainX = []
trainY = []

n_future = 1   # Number of days we want to look into the future based on the past days.
n_past = 7  # Number of past days we want to use to predict the future.
#Reformat input data into a shape: (n_samples x timesteps x n_features)
for i in range(n_past, len(X_scaled) - n_future +1):
    trainX.append(X_scaled[i - n_past:i, 0:X_scaled.shape[1]])
    trainY.append(X_scaled[i + n_future - 1:i + n_future, 0])

trainX, trainY = np.array(trainX), np.array(trainY)


X_train, X_test, y_train, y_test = train_test_split(trainX, trainY, test_size = 0.2, random_state = 0)
    
lstm_model = Sequential()

lstm_model.add(LSTM(256, input_shape=(trainX.shape[1], trainX.shape[2]), activation='relu', 
                        kernel_initializer='lecun_uniform', return_sequences=True))
lstm_model.add(LSTM(128, activation='relu', return_sequences=False))
lstm_model.add(Dense(1))

lstm_model.compile(loss='mean_squared_error', optimizer='adam',metrics =["mae"])
    
early_stop = keras.callbacks.EarlyStopping(monitor='loss', patience=2, verbose=1)

history_lstm_model = lstm_model.fit(X_train, y_train, epochs=100, batch_size=32, shuffle=False, callbacks=[early_stop])
    
  

lstm_model.save('Model/model3_temp.h5')
keras.models.load_model('Model/model3_temp.h5')
train_dates = pd.to_datetime(df['DATE_TIME'])
n_past = 1
n_days_for_prediction= 8

prediction_temp = lstm_model.predict(X_train[-n_days_for_prediction:])
prediction_copies_temp = np.repeat(prediction_temp, X_train.shape[1], axis=-1)
y_pred_future_temp = min_max_scaler.inverse_transform(prediction_copies_temp)[:,0]
y_pred_future_temp = np.round(y_pred_future_temp, decimals=2)


predict_period_dates = pd.date_range(list(train_dates)[-n_past], periods=n_days_for_prediction).tolist()
forecast_dates = []
for time_i in predict_period_dates:
    forecast_dates.append(time_i.date())

df_forecast = pd.DataFrame({'FISH_TANK_NUMBER':'3','FORCA_DATE':np.array(forecast_dates), 'FORCA_DISSOLVED_OXYGEN':y_pred_future_do, 'FORCA_PH_VALUE':y_pred_future_ph, 'FORCA_WATER_TEMPERATURE':y_pred_future_temp})
df_forecast['FORCA_DATE']=pd.to_datetime(df_forecast['FORCA_DATE'])



cursor=mydb.cursor()
cols = "`,`".join([str(i) for i in df_forecast.columns.tolist()])

# Insert DataFrame recrds one by one.
for i,row in df_forecast.iterrows():
    sql = "INSERT INTO `forecast_water_quality_data` (`" +cols + "`) VALUES (" + "%s,"*(len(row)-1) + "%s)"
    cursor.execute(sql, tuple(row))

    # the connection is not autocommitted by default, so we must commit to save our changes
    mydb.commit()








