from __future__ import print_function
from pyspark import SparkConf, SparkContext
from pyspark.sql import SQLContext
from cleantext import sanitize
from pyspark.ml.feature import CountVectorizer
from pyspark.sql.functions import split, col
from pyspark.sql.types import *

# IMPORT OTHER MODULES HERE
def select(ngrams):
	return ngrams[1] + " " + ngrams[2] + " " + ngrams[3]

def vectorize(ngrams):
	unigram = ngrams[1]
	bigram = ngrams[2]
	trigram = ngrams[3]
	unigram_vector = unigram.split(" ")
	bigram_vector = bigram.split(" ")
	trigram_vector = trigram.split(" ")
	ret = unigram_vector + bigram_vector + trigram_vector
	return ret

def check_pos(label):
	if label == 1:
		return 1
	return 0

def check_neg(label):
	if label == -1:
		return 1
	return 0
	
def link_id(id):
	res = re.sub('t3_', '', id)
	return res

def remove(string):
        if(string.find('/s') == -1 or string.find('&gt') != 0):
            return True
        return False


def main(context):
	"""Main function takes a Spark SQL context."""
	"""Task1"""
	#commentsDF = sqlContext.read.json("comments-minimal.json.bz2")
	#submissionsDF = sqlContext.read.json("submissions.json.bz2")
	#commentsDF.write.parquet("comments.parquet")
	#submissionsDF.write.parquet("submissions.parquet")
	labeledDF = sqlContext.read.format("csv").options(header='true', inferschema='true').load("labeled_data.csv")
	commentsDF = sqlContext.read.parquet("comments.parquet")
	submissionsDF = sqlContext.read.parquet("submissions.parquet")

	"""Task2"""
	#data = labeled_data.join(comments, comments("id")===labeled_data("Input_id"), "inner").select("id","body","labeldem","labelgop","labeldjt")
	commentsDF.createOrReplaceTempView("comments")
	labeledDF.createOrReplaceTempView("labeled_data")
	dataDF = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt FROM comments INNER JOIN labeled_data ON comments.id = labeled_data.Input_id")
	'''drop the temp view to save memory (RAM)'''

	"""Task4"""
	dataDF.createOrReplaceTempView("data")
	sqlContext.udf.register("sanitize_udf", sanitize)
	dataDF = sqlContext.sql("SELECT *, sanitize_udf(body) AS ngrams FROM data")

	"""Task5"""
	dataDF.createOrReplaceTempView("data")
	sqlContext.udf.register("select_udf", select)
	data = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt, select_udf(ngrams) AS selected_ngrams FROM data")
	#data = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt, vectorize_udf(ngrams) AS vectorized_ngrams FROM data")

	"""Task6A"""
	vectorized_data = data.withColumn("selected_ngrams", split(col("selected_ngrams"), " ").cast(ArrayType(StringType())))
	cv = CountVectorizer(inputCol="selected_ngrams", outputCol="vector", minDF=5.0)
	cv_model = cv.fit(vectorized_data)
	vectorized = cv_model.transform(vectorized_data)
	#vectorized.show(1, truncate=False)

	"""Task6B"""
	vectorized.createOrReplaceTempView("Vectorized")
	sqlContext.udf.register("check_pos", check_pos)
	sqlContext.udf.register("check_neg", check_neg)
	new_vectorized = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt, selected_ngrams, vector, check_pos(labeldjt) AS pos_label, check_neg(labeldjt) AS neg_label FROM Vectorized")
	new_vectorized.show(3, False)

	# """Task7"""
	# # Bunch of imports (may need more)
	# from pyspark.ml.classification import LogisticRegression
	# from pyspark.ml.tuning import CrossValidator, ParamGridBuilder
	# from pyspark.ml.evaluation import BinaryClassificationEvaluator
	# pos = sqlContext.sql('select positive, features from data')
	# neg = sqlContext.sql('select negative, features from data')
	# # Initialize two logistic regression models.
	# # Replace labelCol with the column containing the label, and featuresCol with the column containing the features.
	# poslr = LogisticRegression(labelCol="label", featuresCol="features", maxIter=10)
	# neglr = LogisticRegression(labelCol="label", featuresCol="features", maxIter=10)
	# # This is a binary classifier so we need an evaluator that knows how to deal with binary classifiers.
	# posEvaluator = BinaryClassificationEvaluator()
	# negEvaluator = BinaryClassificationEvaluator()
	# # There are a few parameters associated with logistic regression. We do not know what they are a priori.
	# # We do a grid search to find the best parameters. We can replace [1.0] with a list of values to try.
	# # We will assume the parameter is 1.0. Grid search takes forever.
	# posParamGrid = ParamGridBuilder().addGrid(poslr.regParam, [1.0]).build()
	# negParamGrid = ParamGridBuilder().addGrid(neglr.regParam, [1.0]).build()
	# # We initialize a 5 fold cross-validation pipeline.
	# posCrossval = CrossValidator(
 #    estimator=poslr,
 #    evaluator=posEvaluator,
 #    estimatorParamMaps=posParamGrid,
 #    numFolds=5)
	# negCrossval = CrossValidator(
 #    estimator=neglr,
 #    evaluator=negEvaluator,
 #    estimatorParamMaps=negParamGrid,
 #    numFolds=5)
	# # Although crossvalidation creates its own train/test sets for
	# # tuning, we still need a labeled test set, because it is not
	# # accessible from the crossvalidator (argh!)
	# # Split the data 50/50

	# posTrain, posTest = vectorized_pos.randomSplit([0.2, 0.8])
	# negTrain, negTest = vectorized_neg.randomSplit([0.2, 0.8])
	# # Train the models
	# print("Training positive classifier...")
	# posModel = posCrossval.fit(posTrain)
	# print("Training negative classifier...")
	# negModel = negCrossval.fit(negTrain)

	# # Once we train the models, we don't want to do it again. We can save the models and load them again later.
	# posModel.save("./www/pos.model")
	# negModel.save("./www/neg.model")
	# """task 8 """
 #    #select from comments DF:
 #    comments_result = context.sql('SELECT id, link_id, body, created_utc, author_flair_text FROM comments_DF')
 #    comments_result.createOrReplaceTempView("comments_result")
 #    comments_result.show()
 #    tmp = comments_result.toPandas()
 #    tmp.to_csv("./www/comments_result.csv", index=False, sep=' ')

 #    submissions_title = context.sql("SELECT id, title FROM submissions_view ORDER BY id")
 #    submissions_result.createOrReplaceTempView("submissions_result")
 #    submissions_result.show()
 #    tmp = submissions_result.toPandas()
 #    tmp.to_csv("./www/submissions_result.csv", index=False, sep=' ')

 #    context.udf.register("remove", remove)
 #    context.udf.register("link_id", link_id)
 #    commands = "SELECT c.id, c.body, c.created_utc, c.author_flair_text, s.title FROM comments_result INNER JOIN submissions_result ON link_id(c.link_id) = s.id"
 #    task8_result = context.sql()
 #    tmp = comments_unseen.toPandas()
 #    tmp.to_csv("./www/task8_result.csv", index=False, sep=' ')
 #    """task 9"""
	




if __name__ == "__main__":
	conf = SparkConf().setAppName("CS143 Project 2B")
	conf = conf.setMaster("local[*]")
	sc   = SparkContext(conf=conf)
	sqlContext = SQLContext(sc)
	sc.addPyFile("cleantext.py")
	main(sqlContext)
